import re
from urllib.request import urlopen
from bs4 import BeautifulSoup

from threading import Timer

import ctypes  # An included library with Python install.

# https://stackoverflow.com/questions/21002712/looking-to-scrape-a-website-daily-and-set-up-alerts
def getsnowday():
    # Get a file-like object using urllib2.urlopen
    url = 'http://lps.lexingtonma.org/Page/929'
    html = urlopen(url)

    # BS accepts a lot of different data types, so you don't have to do e.g.
    # urlopen(url).read(). It accepts file-like objects, so we'll just send in html
    # as a parameter.
    soup = BeautifulSoup(html)
    text = soup.find('p').text
    
    if text.find('in session') == -1:
        ctypes.windll.user32.MessageBoxA(0, text.strip().encode('utf-8'), b"SNOW DAY", 0x00001000)
    else:
        print(text)
    # https://stackoverflow.com/questions/2697039/python-equivalent-of-setinterval
    Timer(30.0, getsnowday).start()

getsnowday()
