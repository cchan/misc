#include <iostream>
#include <vector>
using namespace std;


template<typename T>
class Polynomial;

template<typename T>
ostream& operator<<(ostream& os, const Polynomial<T>& p);

template<typename T>
class Polynomial{
private:
	vector<T> coeffs;
public:
	friend ostream& operator<< <T>(ostream& os, const Polynomial<T>& p);
	Polynomial<T>(){};
	Polynomial<T>(const Polynomial<T> &p){coeffs = p.coeffs;}
	Polynomial<T>(vector<T> _coeffs){coeffs = _coeffs;}
	
	const T& operator[](size_t i) const{
		if(i >= coeffs.size()) return 0;
		else return coeffs[i];
	}
	T& operator[](size_t i){
		if(i >= coeffs.size())
			coeffs.resize(i+1);
		return coeffs.at(i);
	}
	
	Polynomial<T> operator+=(const Polynomial<T>& other){
		if(other.coeffs.size() > coeffs.size())
			coeffs.resize(other.coeffs.size());
		for(int i = 0; i < coeffs.size() && i < other.coeffs.size(); i++)
			coeffs[i] += other.coeffs[i];
	}
	Polynomial<T> operator*=(const T& scalar){
		for(T& c : coeffs)
			c *= scalar;
	}
	Polynomial<T> operator*(const T& scalar) const{
		Polynomial<T> p(this);
		p *= scalar;
		return p;
	}
	Polynomial<T> operator<<=(size_t shift){
		coeffs.insert(coeffs.begin(), shift);
	}
	Polynomial<T> operator<<(size_t shift) const{
		Polynomial<T> p(*this);
		p <<= shift;
		return p;
	}
	Polynomial<T> operator*(const Polynomial<T>& other) const{
		Polynomial<T> p;
		p.coeffs.resize(coeffs.size() + other.coeffs.size() - 1);
		for(int i = 0; i < coeffs.size(); i++)
			for(int j = 0; j < other.coeffs.size(); j++)
				p.coeffs[i+j] += coeffs[i] * other.coeffs[j];
		return p;
	}
	Polynomial<T> operator*=(const Polynomial<T>& other){
		Polynomial<T> p = *this * other;
		coeffs = p.coeffs;
	}
};

template<typename T>
ostream& operator<<(ostream& os, const Polynomial<T>& p){
	os << p[0];
	for(int i = 1; i < p.coeffs.size(); i++){
		os << " + " << p.coeffs[i] << "x";
		if(i > 1) os << "^" << i;
	}
	return os;
}


int main() {
	Polynomial<int> p1({1,2,3}), p2({4,5,6});
	cout << p1 << endl << p2 << endl << p1 * p2 << endl;
	return 0;
}