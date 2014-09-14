<?php if (!defined('APPLICATION')) exit();
/*
Trickno chat plugin
*/

// Define the plugin:
$PluginInfo['Chat'] = array(
    'Description'          => 'some chat shit',
    'Version'              => '1.0',
    'RequiredApplications' => array('Vanilla' => '2.0.10'),
    'RequiredTheme'        => FALSE, 
    'RequiredPlugins'      => FALSE,
    'HasLocale'            => FALSE,
    'SettingsUrl'          => '/plugin/chat',
    'SettingsPermission'   => 'Garden.AdminUser.Only',
    'Author'               => "er0k",
    'AuthorEmail'          => 'er0k@er0k.net',
    'AuthorUrl'            => 'http://tricknologic.com'
);

class ChatPlugin extends Gdn_Plugin {

    /**
    * Plugin constructor
    *
    * This fires once per page load, during execution of bootstrap.php. It is a decent place to perform
    * one-time-per-page setup of the plugin object. Be careful not to put anything too strenuous in here
    * as it runs every page load and could slow down your forum.
    */
    public function __construct() {
      
    }

    public function EntryController_Register_Create($Sender) {
        if (!$Sender->Request->IsPostBack())
            $Sender->CheckOverride('Register', $Sender->Target());

        $Sender->FireEvent("Register");

        $Sender->Form->SetModel($Sender->UserModel);

        // Define gender dropdown options
        $Sender->GenderOptions = array(
         'u' => T('Unspecified'),
         'm' => T('Male'),
         'f' => T('Female')
        );

        // Make sure that the hour offset for new users gets defined when their account is created
        $Sender->AddJsFile('entry.js');

        $Sender->Form->AddHidden('ClientHour', date('Y-m-d H:00')); // Use the server's current hour as a default
        $Sender->Form->AddHidden('Target', $Sender->Target());

        $Sender->SetData('NoEmail', UserModel::NoEmail());

        $RegistrationMethod = 'RegisterBasic';
        $Sender->View = $RegistrationMethod;
        $Sender->$RegistrationMethod($InvitationCode);
    }

    public function EntryController_RegisterBasic_Create($Sender) {
        // print_r($Values);
        // die('ok');

        Gdn::UserModel()->AddPasswordStrength($Sender);

        if ($Sender->Form->IsPostBack() === TRUE) {
           // Add validation rules that are not enforced by the model
           $Sender->UserModel->DefineSchema();
           $Sender->UserModel->Validation->ApplyRule('Name', 'Username', $Sender->UsernameError);
           $Sender->UserModel->Validation->ApplyRule('TermsOfService', 'Required', T('You must agree to the terms of service.'));
           $Sender->UserModel->Validation->ApplyRule('Password', 'Required');
           $Sender->UserModel->Validation->ApplyRule('Password', 'Strength');
           $Sender->UserModel->Validation->ApplyRule('Password', 'Match');
           // $Sender->UserModel->Validation->ApplyRule('DateOfBirth', 'MinimumAge');

           $Sender->FireEvent('RegisterValidation');

           try {
              $Values = $Sender->Form->FormValues();
              unset($Values['Roles']);
              $AuthUserID = $Sender->UserModel->Register($Values);
              if ($AuthUserID == UserModel::REDIRECT_APPROVE) {
                 $Sender->Form->SetFormValue('Target', '/entry/registerthanks');
                 $Sender->_SetRedirect();
                 return;
              } elseif (!$AuthUserID) {
                 $Sender->Form->SetValidationResults($Sender->UserModel->ValidationResults());
              } else {
                 // The user has been created successfully, so sign in now.
                 Gdn::Session()->Start($AuthUserID);

                 if ($Sender->Form->GetFormValue('RememberMe'))
                    Gdn::Authenticator()->SetIdentity($AuthUserID, TRUE);

                 try {
                    $Sender->UserModel->SendWelcomeEmail($AuthUserID, '', 'Register');
                 } catch (Exception $Ex) {
                 }

                 $Sender->FireEvent('RegistrationSuccessful');

                 // ... and redirect them appropriately
                 $Route = $Sender->RedirectTo();
                 if ($this->_DeliveryType != DELIVERY_TYPE_ALL) {
                    $Sender->RedirectUrl = Url($Route);
                 } else {
                    if ($Route !== FALSE)
                       Redirect($Route);
                 }
              }
           } catch (Exception $Ex) {
              $Sender->Form->AddError($Ex);
           }
        }
        $Sender->Render();
    }



    /**
    * Create a method called "Example" on the PluginController
    *
    * One of the most powerful tools at a plugin developer's fingertips is the ability to freely create
    * methods on other controllers, effectively extending their capabilities. This method creates the 
    * Example() method on the PluginController, effectively allowing the plugin to be invoked via the 
    * URL: http://www.yourforum.com/plugin/Example/
    *
    * From here, we can do whatever we like, including turning this plugin into a mini controller and
    * allowing us an easy way of creating a dashboard settings screen.
    *
    * @param $Sender Sending controller instance
    */
    public function PluginController_Chat_Create($Sender) {
        /*
        * If you build your views properly, this will be used as the <title> for your page, and for the header
        * in the dashboard. Something like this works well: <h1><?php echo T($this->Data['Title']); ?></h1>
        */
        $Sender->Title('Chat Plugin');
        $Sender->AddSideMenu('plugins/chat');

        // If your sub-pages use forms, this is a good place to get it ready
        $Sender->Form = new Gdn_Form();

        /*
        * This method does a lot of work. It allows a single method (PluginController::Example() in this case) 
        * to "forward" calls to internal methods on this plugin based on the URL's first parameter following the 
        * real method name, in effect mimicing the functionality of as a real top level controller. 
        *
        * For example, if we accessed the URL: http://www.yourforum.com/plugin/Example/test, Dispatch() here would
        * look for a method called ExamplePlugin::Controller_Test(), and invoke it. Similarly, we we accessed the
        * URL: http://www.yourforum.com/plugin/Example/foobar, Dispatch() would find and call 
        * ExamplePlugin::Controller_Foobar().
        *
        * The main benefit of this style of extending functionality is that all of a plugin's external API is 
        * consolidated under one namespace, reducing the chance for random method name conflicts with other
        * plugins. 
        *
        * Note: When the URL is accessed without parameters, Controller_Index() is called. This is a good place
        * for a dashboard settings screen.
        */
        $this->Dispatch($Sender, $Sender->RequestArgs);
    }

    public function Controller_Index($Sender) {
        // Prevent non-admins from accessing this page
        $Sender->Permission('Vanilla.Settings.Manage');

        $Sender->SetData('PluginDescription',$this->GetPluginKey('Description'));

        $Validation = new Gdn_Validation();
        $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
        $ConfigurationModel->SetField(array(
            'Plugins.Chat.Domain' => 'localhost'
        ));
      
        // Set the model on the form.
        $Sender->Form->SetModel($ConfigurationModel);

        // If seeing the form for the first time...
        if ($Sender->Form->AuthenticatedPostBack() === FALSE) {
            // Apply the config settings to the form.
            $Sender->Form->SetData($ConfigurationModel->Data);
        } else {
            $ConfigurationModel->Validation->ApplyRule('Plugins.Chat.Domain', 'Required');

            $Saved = $Sender->Form->Save();
            if ($Saved) {
                $Sender->StatusMessage = T("Your changes have been saved.");
            }
        }
      
        // GetView() looks for files inside plugins/PluginFolderName/views/ and returns their full path. Useful!
        $Sender->Render($this->GetView('chat.php'));
    }

    /**
    * Add a link to the dashboard menu
    * 
    * By grabbing a reference to the current SideMenu object we gain access to its methods, allowing us
    * to add a menu link to the newly created /plugin/Example method.
    *
    * @param $Sender Sending controller instance
    */
    public function Base_GetAppSettingsMenuItems_Handler($Sender) {
        $Menu = &$Sender->EventArguments['SideMenu'];
        $Menu->AddLink('Add-ons', 'Chat', 'plugin/chat', 'Garden.AdminUser.Only');
    }

    

    /**
    * Plugin setup
    *
    * This method is fired only once, immediately after the plugin has been enabled in the /plugins/ screen, 
    * and is a great place to perform one-time setup tasks, such as database structure changes, 
    * addition/modification ofconfig file settings, filesystem changes, etc.
    */
    public function Setup() {

      // Set up the plugin's default values
      SaveToConfig('Plugins.Chat.Domain', "localhost");

      /*
      // Create table GDN_Example, if it doesn't already exist
      Gdn::Structure()
         ->Table('Example')
         ->PrimaryKey('ExampleID')
         ->Column('Name', 'varchar(255)')
         ->Column('Type', 'varchar(128)')
         ->Column('Size', 'int(11)')
         ->Column('InsertUserID', 'int(11)')
         ->Column('DateInserted', 'datetime')
         ->Column('ForeignID', 'int(11)', TRUE)
         ->Column('ForeignTable', 'varchar(24)', TRUE)
         ->Set(FALSE, FALSE);
      */
    }

    /**
    * Plugin cleanup
    *
    * This method is fired only once, immediately before the plugin is disabled, and is a great place to 
    * perform cleanup tasks such as deletion of unsued files and folders.
    */
    public function OnDisable() {
      RemoveFromConfig('Plugins.Chat.Domain');
    }
   
}
