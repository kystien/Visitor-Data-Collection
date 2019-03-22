# Visitor-Data-Collection
Collect data from visitors to your website pages including the number of return visits &amp; geolocation.


So I originally started this project because I was pissed off with right-wingers using anonymous handles on various social media platforms to spread their garbage. After the attacks on New Zealand on March 15 2019... that event set me off. Reason being is that I read buddies manifesto and everything he said in it was everything that right-wing parties across the world have been spouting for the last decade.

So I got pissed off with one anon handle on twitter and then another and another... It was like they were taunting us. "Oh look at us, we can say whatever the fuck we want without anyone doing shit all to us. Freedom of speech muzzie lovers & faggots!"

And so ya... I embarked on this project in anger and have since come from it with a new sense of respect for the many companies that collect this data daily. Additionally it has given me respect for the authorities that try and collect this data in the coarse of their investigations.

Special note: All data that was collected in my initial testing and public trial has been deleted from all systems, servers and personal devices.

# VDC Setup Instructions

1) Download these files or use git via ssh to clone the archive to your web host.
  If you download the files to your own system, extract the archive and upload to your webhost directory.
  Ensure your host allows for PHP execution as well.
  
2) Once on the host change the filename for Wow.php to index.php.

3) create a text file called users.txt

4) chmod the users.txt file to 222.

5) chmod the index & function php files to 755.

6) Update the index file html to reflect what you want it to look like for the end-user.

7) I assume you have a Domain name and URL, at which point toss the link for the page out in the while and wait for folks to visit to view the data.


# Warning

The data that is collected can be powerful information to have. IP addresses and geolocation is one thing. It is when you use that data in tools like the Android app ITraceroute and other ip tracing tools that have a graphical interface that narrows the endusers IP to their general Neighbourhoods.

# DO NOT use the information gathered for illegal purposes! That includes for doxing.
