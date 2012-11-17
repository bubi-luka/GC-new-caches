/*******************************************************************************
*	This is the file containing configuration and personification options for    *
*	the GC-script application. To start using it please rename it to             *
* "config.php" and fill in the missing variables. To activate an inactive      *
* variable please remove the "#" from the beginning of the line.               *
*******************************************************************************/

/*******************************************************************************
* Please insert the complete url taken from the geocaching.com site that       *
* holds data of all caches for your country and is sorted by publication date  *
*******************************************************************************/
# geocaching-url: ;

/*******************************************************************************
* Please insert email addresses of people that you wish to notify of a new     *
* cache, seperated with comma.                                                 *
*******************************************************************************/
# users: ;

/*******************************************************************************
* Set from email address.                                                      *
*******************************************************************************/
from-email: ;

/*******************************************************************************
* Set reply to email address.                                                      *
*******************************************************************************/
reply-email: ;

/*******************************************************************************
* Would you like the script to create backup copies of the database? Mark "1"  *
* for "Yes, I would like the script to create backup copies of the database    *
* and "0" if you would prefere not to create backup copies.                    *
* WARNING: The number of backups can be very high if you set up high refresh   *
* rate, so be carefull not to overload the server! Delete redundand copies!    *
*******************************************************************************/
backups: 0;

/*******************************************************************************
* Set this variable to "1" if you would like to run the script in debug mode.  *
* This is useful for testing the installation. Since the script produce        *
* HTML output, please use it for initial testing only and than change to "0".  *
*******************************************************************************/
debug-mode: 1;

/*******************************************************************************
* This variable defines if the script will send e-mail notices to users or     *
* it will produce only HTML output. Set the variable to "1" for sending emails *
* and to "0" for not sending any emails.                                       *
*******************************************************************************/
email-mode: 1;

/*******************************************************************************
* This variable sets the script to send e-mails on every script run. If set to *
* "1" it will send email in every run. When there are new caches it will list  *
* them, if there are no new caches it will just confirm the script has fired   *
* and the mailing works. Useful for testing. Is the variable is set to "0",    *
* the mail is send only when a cache is discovered.                            *
*******************************************************************************/
send-any-email: 1;

