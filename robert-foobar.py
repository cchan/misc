# def solution(n, b):
  # lastSeen, i = {}, 0
  # while True:
    # lastSeen[''.join(sorted(n))], n, i = i, ''.join(sorted(str((int(''.join(sorted(n))[::-1], b) - int(''.join(sorted(n)), b))//b**j%b) for j in range(len(n)))), i + 1
    # if n in lastSeen:
      # return i - lastSeen[n], lastSeen

#def solution(n, b, lastSeen = {}, i = 0):
#  return (i - lastSeen[n], lastSeen) if n in lastSeen else (solution(''.join(sorted(str((int(''.join(sorted(n))[::-1], b) - int(''.join(sorted(n)), b))//b**j%b) for j in range(len(n)))), b, dict(list(lastSeen.items()) + [(''.join(sorted(n)), i)]), i + 1))

solution=lambda n,b,r={},i=0,s=sorted,j=''.join:n in r and(i-r[n],r)or(solution(j(s(str((int(j(s(n))[::-1],b)-int(j(s(n)),b))//b**k%b)for k in range(len(n)))),b,dict(r.items(),**{j(s(n)):i}),i+1))

print(solution("210022", 3))
print(solution("1211", 10))
print(solution("6174", 10))
