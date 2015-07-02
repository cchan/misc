#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include <sstream>
#include <algorithm>
using namespace std;

int binSearchDictionary(const vector<string>& haystack, string needle){
	int min = 0, max = haystack.size() - 1, mid;
	while (min <= max){
		mid = (min + max) / 2;
		//cout << min << " " << mid << " " << max << endl;
		if (haystack[mid].compare(needle) > 0) // needle < haystack[mid]
			max = mid - 1;
		else if (haystack[mid].compare(needle) < 0) // needle > haystack[mid]
			min = mid + 1;
		else
			return mid;
	}
	return -1;
}
int main(){
	string path = "C:/Users/Clive/Desktop/n+7";
	ifstream dict(path + "/nounsFiltered.csv"), poem(path + "/poem.txt");

	vector<string> words;
	string tmp;

	cout << "Starting dictionary read... ";
	while(dict >> tmp)words.push_back(tmp);
	cout << "Done! Read " << words.size() << " words into memory." << endl;


	cout << "N + K Translation: ";

	//http://www.cplusplus.com/forum/articles/6046/
	int k = 0;
	while (true) {
		cout << "k = ? ";
		getline(cin, tmp);

		// This code converts from string to number safely.
		stringstream myStream(tmp);
		if (myStream >> k)
			break;
		cout << "Invalid number, please try again. " << endl;
	}


	while(getline(poem,tmp)){
		stringstream line(tmp);
		string raw, word;

		while (line >> raw){
			word = "";
			for (char &c : raw){
				if (c >= 'A' && c <= 'Z')
					word += c + 'a' - 'A';
				else if (c >= 'a' && c <= 'z')
					word += c;
			}

			int index = binSearchDictionary(words, word);
			if (index == -1){
				if (word[word.length() - 1] == 's'){
					index = binSearchDictionary(words, word.substr(0, word.length() - 1));
					if (index == -1)
						cout << "[" << word << "] ";
					else
						cout << words[index + k] << "[s] ";
				}
				else
					cout << "[" << word << "] ";
			}
			else cout << words[index + k] << " ";
		}

		cout << endl;
	}

	cin.get();
}
