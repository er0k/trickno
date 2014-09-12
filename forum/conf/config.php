<?php if (!defined('APPLICATION')) exit();

// Conversations
$Configuration['Conversations']['Version'] = '2.2.16';

// EnabledApplications
$Configuration['EnabledApplications']['Conversations'] = 'conversations';
$Configuration['EnabledApplications']['Vanilla'] = 'vanilla';

// EnabledPlugins
$Configuration['EnabledPlugins']['GettingStarted'] = 'GettingStarted';
$Configuration['EnabledPlugins']['HtmLawed'] = 'HtmLawed';
$Configuration['EnabledPlugins']['ButtonBar'] = TRUE;
$Configuration['EnabledPlugins']['AllViewed'] = TRUE;
$Configuration['EnabledPlugins']['Debugger'] = TRUE;
$Configuration['EnabledPlugins']['Emotify'] = TRUE;
$Configuration['EnabledPlugins']['VanillaInThisDiscussion'] = TRUE;
$Configuration['EnabledPlugins']['ProfileExtender'] = TRUE;
$Configuration['EnabledPlugins']['VanillaStats'] = TRUE;
$Configuration['EnabledPlugins']['cleditor'] = TRUE;

// Garden
$Configuration['Garden']['Title'] = 'v3.trickno';
$Configuration['Garden']['Cookie']['Salt'] = 'D0WIMJLMBR';
$Configuration['Garden']['Cookie']['Domain'] = '';
$Configuration['Garden']['Registration']['ConfirmEmail'] = '1';
$Configuration['Garden']['Registration']['Method'] = 'Captcha';
$Configuration['Garden']['Registration']['ConfirmEmailRole'] = '3';
$Configuration['Garden']['Registration']['CaptchaPrivateKey'] = '6Lev4fkSAAAAAB4F_a3DEnmKOu0Fow8UWS1_WTPA';
$Configuration['Garden']['Registration']['CaptchaPublicKey'] = '6Lev4fkSAAAAAEkgqZ4xAAP7mRVu3lJW5CU3P3Dr';
$Configuration['Garden']['Registration']['InviteExpiration'] = '1 week';
$Configuration['Garden']['Registration']['InviteRoles']['3'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['4'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['8'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['16'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['32'] = '0';
$Configuration['Garden']['Email']['SupportName'] = 'v3.trickno';
$Configuration['Garden']['InputFormatter'] = 'Html';
$Configuration['Garden']['Version'] = '2.2.16';
$Configuration['Garden']['RewriteUrls'] = TRUE;
$Configuration['Garden']['CanProcessImages'] = TRUE;
$Configuration['Garden']['SystemUserID'] = '2';
$Configuration['Garden']['Installed'] = TRUE;
$Configuration['Garden']['InstallationID'] = 'FA4F-26B2F70E-88E6393B';
$Configuration['Garden']['InstallationSecret'] = 'e299adbdad86ae8e9b1b9817b5034916ac9faf1f';
$Configuration['Garden']['Theme'] = 'trickno';
$Configuration['Garden']['Embed']['Allow'] = TRUE;
$Configuration['Garden']['Embed']['RemoteUrl'] = 'https://tricknologic.com/v3/forum.html';
$Configuration['Garden']['Embed']['ForceDashboard'] = FALSE;
$Configuration['Garden']['Embed']['ForceForum'] = '1';
$Configuration['Garden']['TrustedDomains'] = array('v3.tricknologic.com', 'tricknologic.com', 'whatever.com', 'asdfasdf');
$Configuration['Garden']['SignIn']['Popup'] = '1';
$Configuration['Garden']['Format']['Hashtags'] = FALSE;
$Configuration['Garden']['Html']['SafeStyles'] = FALSE;
$Configuration['Garden']['HomepageTitle'] = 'v3.trickno';
$Configuration['Garden']['Description'] = '';

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Registration'] = '1';
$Configuration['Plugins']['GettingStarted']['Categories'] = '1';
$Configuration['Plugins']['GettingStarted']['Discussion'] = '1';

// Routes
$Configuration['Routes']['DefaultController'] = 'discussions';

// Vanilla
$Configuration['Vanilla']['Version'] = '2.2.16';

// Last edited by er0k (68.82.91.127)2014-09-12 06:33:05