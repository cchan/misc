import urllib2
from bs4 import BeautifulSoup

"""Completely separate idea: http://www.symbaloo.com/ but even better - actual screenshots, on a metroish interface"""

"""
Portable Microsite Manager

Creates a website with the HTML5/SASS/JQuery/PHP/MySQL stack. [honestly, heroku with non-php is probably easier]

Split into components:
    Webmaster Initializer - domain, hosting, mx, pingdom, ga
    Local Initializer - git, git-sftp, H5BP + ? files
    [Each line in the Setup process down there can be a very valuable webmaster tool. Made with one unified API, it's pretty easy to merge all together.]

[you probably need to read a lot of captchas :D]


INTENDED AWESOME USAGE

~ $> microsite setup F:
Setting up portable microsite manager on drive F:
[set up ssh keys if necessary, etc.]
[add your Google account (email, webmaster tools, GA), etc.]
[add Namecheap or other coupons, or PayPal]
[add your 000webhost account]
[add godaddy/namecheap/etc. accounts if necessary]
[add all sorts of other accounts you create manually]
[sets up SSH - stores pass?]
(encrypts all these accounts with openssl, unlock with single password)
[installs git shell with lots of pre-run commands (.bashrc but not in .bashrc)]
[puts FileZilla, npp, photoeditor (smush.it for image-size-shrinking), 7zip, chrome, sass, git, xampp (!?), whatever on the drive]
[Markdown formatter?]


~/github $ microsite create moo.com
moo.com is available!
Looking for prices... GoDaddy Namecheap bla bla...
Best deal $9.84 with GoDaddy. You also have Namecheap coupons available.
(y = buy, n = cancel, c = use coupon) c
Successfully bought domain moo.com with Namecheap coupon [####]!
Setting up hosting... Successfully set up 000webhost.com hosting!
Setting up DNS mail exchange records... Successfully set up forwarding with improvmx.com! [may not be necessary with some hosting services]
Setting up Pingdom and Uptime Robot... done!
Setting up Google Webmaster Tools and Google Analytics... done!
Setting up SSL certificate... done!
    https://www.cloudflare.com/ssl free SSL certs!?
Setting up Git repository... done!
Setting up git-sftp... done!
[somethingsomething SEO?]
You have no files currently. Initialize with (h = h5bp, p = h5bp-php, w = wordpress, n = none) p
    initializes with subset of h5bp (+maybe bootstrap)
        metas already initialized with your name, etc.
    Optionally, plus some php libraries (meekro, functions, etc) http://www.binpress.com/tutorial/php-bootstrapping-crash-course/146
    Or, you can use WP, or import from places (weebly zip), or use various themes possibly
Initializing h5bp-php files... done!
Committing and pushing example site... done!
All done! Within an hour or two your website should be fully operational.
You should start by writing in the README.MD file everything you knkow about the site.
    (It's not in the Public folder, so don't worry if it contains private data. Don't push private stuff though!]


~/github/moo.com $ microsite status
Git status:
...
Website status:
[GA]
[Uptime]


~/github/moo.com $ microsite db
[opening phpMyAdmin...]




"""

