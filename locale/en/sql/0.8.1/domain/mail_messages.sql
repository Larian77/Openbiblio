insert into %prfx%mail_messages
values (
  1
  ,'password_forgotten_message'
  ,''
  ,'Openbiblio-Service'
  ,'New password for your account on Openbiblio'
  ,'<p>Hello %FirstName% %LastName%:</p>
    <p>You have been asked for a new password for your Openbiblio account. To assign a 
new password, go to the following website within the next few %PwdForgottenCodeDuration% hours: %url_pwdcode%</p>
<p>If you have remembered your password or have not done so, please ignore this email.</p>
<p>Best regards,<br />
your Openbiblio team</p>'
  ,'Hello %FirstName% %LastName%:

You have been asked for a new password for your Openbiblio account. To assign a 
new password, go to the following website within the next %PwdForgottenCodeDuration% few hours: %url_pwdcode%

If you have remembered your password or have not done so, please ignore this email.

Best regards,
your Openbiblio team'
  ,true
);
insert into %prfx%mail_messages
values (
  2
  ,'welcome_message'
  ,''
  ,'Openbiblio-Service'
  ,'Herzlich Wlllkomen auf Openbiblio'
  ,'<p>Hallo %FirstName% %LastName%,</p>
    <p>für deinen Account auf Openbiblio wurde nach einem neuen Passwort gefragt. Um ein 
neues Passwort zu vergeben, rufe innerhalb der nächsten %PwdForgottenCodeDuration% Stunden die folgende Website auf: %url_pwdcode%</p>
<p>Sollte dir dein Passwort wieder eingefallen sein oder hast du dies nicht veranlasst, so ignoriere bitte diese E-Mail</p>
<p>Viele Grüße,<br />
dein Openbiblio-Team</p>'
  ,'Hallo %FirstName% %LastName%,

für deinen Account auf Openbiblio wurde nach einem neuen Passwort gefragt. Um ein neues Passwort zu vergeben, rufe innerhalb der nächsten %PwdForgottenCodeDuration% Stunden die folgende Website auf: %url_pwdcode%

Sollte dir dein Passwort wieder eingefallen sein oder hast du dies nicht veranlasst, so ignoriere bitte diese E-Mail.

Viele Grüße,
dein Openbiblio-Team'
  ,true
);
