netsh wlan set hostednetwork mode=allow ssid=scoutserver key=qwertyuiop
netsh wlan start hostednetwork

pause

netsh wlan set hostednetwork mode=disallow

pause

