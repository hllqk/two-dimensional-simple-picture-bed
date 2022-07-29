import requests,random
from bs4 import BeautifulSoup
from ua import *
length=len(ua_list)
ran=random.randint(0,length-1)
rua=ua_list[ran]
url='http://www.shui.tk/2021/11/10/%E6%B0%B4%E5%95%8A%E7%9A%84%E7%BD%91%E7%9B%98.html'
headers={'User-Agent':rua}
c=requests.get(url,headers=headers).text
bf=BeautifulSoup(c,'lxml')
con=bf.find_all('article',class_='markdown-body')
print(con[0])