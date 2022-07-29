from urllib import request
from wsgiref import headers
from bs4 import BeautifulSoup
import urllib.request
import random
import os
from ua import *
import sys,io
print('开始下载')
sys.stdout = io.TextIOWrapper(sys.stdout.buffer,encoding='utf8')
length=len(ua_list)
ran=random.randint(0,length-1)
rua=ua_list[ran]
def gettext(url):
    global rua
    headers={'User-Agent':rua}
    req=request.Request(url=url,headers=headers)
    res=request.urlopen(req)
    html=res.read()
    bf=BeautifulSoup(html,features='lxml')
    con=bf.find_all('div',id='content')
    r=con[0].text.replace('<ul>','')
    return r
text=gettext('https://www.wenku8.net/novel/0/842/28026.htm')    
le=len(text)
for i in range(le):
    file=open('xs.html','a+',encoding='utf-8')
    file.write(str(text[i]))
    file.flush()
    sys.stdout.write('\r已经下载: %.3f '%(float(i/le)*100)+'%')
    sys.stdout.flush()
    file.close()
print('下载完成')