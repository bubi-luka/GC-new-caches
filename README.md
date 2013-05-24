GC New Caches Script
=

GeoCacher script, that chackes main GC page for new caches and mail registered users about them.

Taken from the official Geocaching site:
Geocaching is a free real-world outdoor treasure hunt. Players try to locate hidden containers, called geocaches, 
using a smartphone or GPS and can then share their experiences online.
Source: http://www.geocaching.com/

Application desription:
=
Since not every user of GeoCaching game is registered as Premium user, as well there is no need them to be, we created 
this short script to get them notified about newly published caches. The script is to be put on the local server, 
capable of running PHP scripts. For best performance the owner should activate crontab to run the script at the 
desired frequency.

Installation:
=
  1) Download the files from this repository to your computer.
  2) Uptade your parameters in the config.php.
  3) Upload the files to a desired directory on your server.
  4) Test your installation by visiting the page: http(s)://your.domain.name/your_directory/index.php
  5) Optional: set crontab to run the script.
  7) Wait for the mail to arrive.
  8) Turn off your computer and go GeoCaching!!!

What does the script do:
=
0) It creates the backup of the database.
1) It loads the desired geocaching page.
2) Extract data about caches.
3) Compare the data to previously saved database.
4) If it finds new caches, it  mails them to the users.
5) Writes new database.

Contributors:
=
The autor would like to say thank you to the following persons or project for their work on the application:
- Marko L. for it's initial work
- PHP Simple HTML DOM project: http://sourceforge.net/projects/simplehtmldom/

Legal notice:
=
This script is, if not otherwise stated, protected with GLPv3. The licence text can be found in the 
downloaded files as well as on this web address: http://www.gnu.org/licenses/gpl.html.
PHP Simple HTML DOM Parser (http://sourceforge.net/projects/simplehtmldom/) is redistributed under MIT licence.
