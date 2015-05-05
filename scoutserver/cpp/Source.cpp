#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include <map>
#include <algorithm>

using namespace std;

const int number_of_teams = 32;
const int number_of_matches = 40;

int main(){
	const int watch_lookahead = 8; //How many matches to look ahead for team-watching
	const int match_lookahead = 4; //How many matches to look ahead for filling
	const vector<string> columnlabels = { "Red 1", "Red 2", "Blue 1", "Blue 2" };
	const vector<int> teams_to_watch = { 4029, 8379 };
	vector<vector<int> > matches(number_of_matches);
	map<int, string> teamnames;
	map<int, int> number_of_matches_each_team_is_in;

	ifstream teamnamefile("C:/Users/Clive/Desktop/github/misc/scoutserver/cpp/TeamNamesStates.txt");
	ifstream teamfile("C:/Users/Clive/Desktop/github/misc/scoutserver/cpp/MatchesStates.txt");

	if (!teamnamefile){ cout << "Error opening team names" << endl; cin.get();  return 1; }
	if (!teamfile){ cout << "Error opening matches" << endl; cin.get();  return 1; }

	for (int i = 0; i < number_of_teams; i++){
		int teamnum;
		char s[256];
		teamnamefile >> teamnum;
		teamnamefile.getline(s, 256);
		teamnames[teamnum] = s;
	}
	for (auto teamname : teamnames)
		cout << teamname.first << ": " << teamname.second << endl;

	bool success = true;
	for (int i = 0; i < number_of_matches; i++){
		matches[i] = vector<int>(4);
		for (int j = 0; j < 4; j++){
			teamfile >> matches[i][j];
			if (!teamnames.count(matches[i][j])) { //Output ALL instances of nonexistent team
				cout << "ERROR: match " << i << ", team " << j << ": " << matches[i][j] << " does not exist" << endl;
				success = false;
			}
			else{
				number_of_matches_each_team_is_in[matches[i][j]]++;
			}
		}
	}

	/*if (teamnamefile.get()){
		cout << "Still extra teams in teamname file" << endl;
		success = false;
	}
	if (teamfile){
		cout << "Still extra teams in matches file" << endl;
		success = false;
	}*/
	if (success){
		cout << "\nSuccessfully verified all matches." << endl;
		for (pair<int, int> nummatches : number_of_matches_each_team_is_in){
			cout << "Team " << nummatches.first << " is in " << nummatches.second << " rounds" << endl;
		}
	}
	else{
		cout << "Errors found in matches." << endl;
		cin.get();
		return 1;
	}

	for (int i = 0; i < number_of_matches; i++){
		cout << "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nMatch " << (i + 1) << " / " << matches.size() << endl << endl << endl  << "Current Match: Match " << (i+1) << endl << endl;
		for (int j = 0; j < 4; j++)
			cout << ((std::find(teams_to_watch.begin(), teams_to_watch.end(), matches[i][j]) != teams_to_watch.end()) ? "* " : "  ") << matches[i][j] << " " << teamnames[matches[i][j]] << "  (" << columnlabels[j] << ")" << endl;

		for (int d = 1; d <= match_lookahead && i + d < number_of_matches; d++){
			i += d;
			cout << "\n\n\nLookahead to Match " << (i + 1) << endl << endl;
			for (int j = 0; j < 4; j++)
				cout << ((std::find(teams_to_watch.begin(), teams_to_watch.end(), matches[i][j]) != teams_to_watch.end()) ? "* " : "  ") << matches[i][j] << " " << teamnames[matches[i][j]] << "  (" << columnlabels[j] << ")" << endl;
			i -= d;
		}

		cout << "\n\n\nTeams being watched: \n\n";

		int to_find = teams_to_watch.size();
		vector<bool> teams_found(to_find);

		for (int x = i + 1; to_find > 0 && x < number_of_matches; x++){
			for (int j = 0; j < teams_to_watch.size(); j++){
				if (teams_found[j]) continue;
				auto found = std::find(matches[x].begin(), matches[x].end(), teams_to_watch[j]);
				if (found != matches[x].end()){
					to_find--;
					teams_found[j] = true;
					cout << matches[x][j] << ": Next match in " << (x - i) << " rounds (round " << (x + 1) << ")" << endl << "     with:    ";
					for (int f = 0; f < 4; f++)
						if (f != j)cout << matches[x][f] << " (" << columnlabels[f] << ") ";
					cout << endl << endl;
				}
			}
		}
		for (int x = 0; x < teams_found.size(); x++){
			if (!teams_found[x])cout << teams_to_watch[x] << ": No more matches" << endl;
		}

		cout << endl;
		cin.get();
	}
	cout << "Done with matches!" << endl;
	cin.get();
}
