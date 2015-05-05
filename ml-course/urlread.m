%% urlread for Coursera
% Written by Clive Chan 2015 https://mathnerd3141.github.io (not affiliated with Coursera)

% WHAT
	% Replacement for Octave's urlread with exactly enough functionality to run the Coursera Machine Learning assignment submission system.
	% For some reason, even though Octave has a fully-functional installation of CURL, it doesn't seem to have its own SSL certificate store.
	% If you use urlread with three parameters for any other legitimate purposes in your code, apologies, but this overrides that.

% HOW
	% Put this file into OCTAVE_HOME/lib
	% Download https://certs.godaddy.com/repository/gd_bundle.crt and put it into OCTAVE_HOME/ssl/certs.
		% (this is a bundle of certificates that help Curl verify the identity of the Coursera server)
	% Proceed contrary to the warning on https://www.coursera.org/learn/machine-learning/supplement/p9ckf/installing-octave-matlab-on-windows

function responseBody = urlread(submissionUrl, post, params)
	bodyEscaped = strrep(params{2},"\"","\\\"");
	home = strrep(OCTAVE_HOME,"\\","/");
	curl = ["\"" home "/bin/curl.exe\""]; % Curl is built-in! Yay.
	cert = ["\"" home "/ssl/certs/gd_bundle.crt\""]; % You need to download and place this file: https://certs.godaddy.com/repository/gd_bundle.crt
	call = [curl " -X POST --cacert " cert " --data \"jsonBody=" bodyEscaped "\" " submissionUrl];
	[curlStatus, responseBody] = system(call);
end
