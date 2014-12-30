#include <iostream>
#include <vector>
#include <map>
using namespace std;

//How many ways are there to assign a secret santa?
//Or, how many ways are there to assign a bijection from a set to itself without any element being assigned itself?
//0: 0
//1: 0
//2: 1
//3: 2
//4: 9
//5: 44

const int MIN_CYCLE_LENGTH = 2;

/*
abcd(3!)
ab cd(4c2 / 2 = 3)

abcde(4!)
abc de(5c3 * 2)
a bcde(0)

f:
1. find all partitions (a1+...+an) of x
2. return sum of all ((a1-1)!+...+(an-1))!
1. partition off 2 and 3
*/


unsigned long long factorial(int a){
	unsigned long long acc = 1;
	for (int i = 0; i < a;)acc *= ++i;
	return acc;
}
/*unsigned long long choose(int a, int b){
	int r = a - b > b ? a - b : b,
		s = a - r;
	unsigned long long acc = 1;
	for (int i = r + 1; i <= a; i++)acc *= i;
	for (int i = 2; i <= s; i++)acc /= i;
	return acc;
}*/
vector<vector<int> > partitions(int x, int min = MIN_CYCLE_LENGTH){
	//search for monotonically (?) nonstrictly increasing seqs
	vector<vector<int> > ps;
	for (int i = min; i <= (x+1)/2; i++){
		vector<vector<int> > sub = partitions(x - i, i);
		for (vector<int> a : sub){
			//append i to each vector of the subpartition (should be prepend, but append is faster and just reverses it)
			a.push_back(i);
			//append mini to p
			ps.push_back(a);
		}
	}
	if (x >= min)ps.push_back({ x }); //To be a bit more efficient, instead of extending the above loop to i<=x.
	return ps;
}
unsigned long long ways(int x){
	//static map<int, unsigned long long> cache({ { 0, 0 }, { 1, 0 }, { 2, 1 }, { 3, 2 } });
	//if (cache.count(x) == 1){
	//	//cout << "hit " << x <<"="<<cache[x]<< endl;
	//	return cache[x];
	//}else{
	//	unsigned long long acc = 0;

	//	if (x > 2)acc += choose(x, 2) * ways(x - 2) * ways(2);
	//	if (x > 3)acc += choose(x, 3) * ways(x - 3) * ways(3);
	//	return cache[x] = acc;
	//}
	vector<vector<int> > ps = partitions(x);
	//for (vector<int>p : ps){ cout << "("; for (int r : p)cout << r << " "; cout << ")"; }
	unsigned long long sum = 0;
	unsigned long long f = factorial(x);
	for (vector<int> p : ps){
		//2, 2 => 3 ()
		//how many ways to make cycles of these sizes
		//(n-1)! (number of ways to permute within one cycle)
		//? (number of ways to get those sizes out of x, elements distinguishable)
		
		unsigned long long subsum = f;//start with the top of the choose fraction thing ((total)!)
		map < int, int > m;//map of partition pieces, counting for duplicates
		for (int a : p)
			//subsum *= factorial(a - 1);subsum /= factorial(a); //permute each cycle, and do the bottom of the whole choose thing
			subsum /= ++m[a] * a; //Divide for duplicate cycles (it's secretly a factorial), and do the above commented line abbreviated.
		sum += subsum;
	}
	return sum;
}
int main(){
	for (int i = 1; i < 20; i++)
		cout << i << ": " << ways(i) << endl;
	cin.get();
}
