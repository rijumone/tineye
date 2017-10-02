# http://matthiaseisen.com/pp/patterns/p0202/

from PIL import Image
import sys, time
import os
from shutil import copyfile

# filePath = "/media/rijumone/Seagate BUP Slim1/bkp/data/Delhi"
# filePath = "/media/rijumone/3AB8-1F06/Download/tmp/data/Delhi"
filePath = "/media/rijumone/BE02-5C63/Download/tmp/done/Delhi"
# /media/rijumone/BE02-5C63/Download/tmp/done/Delhi/1504675730
# first create image 1920 + height

directory, height = sys.argv[1:1+2]

copyfile(filePath + "/" + directory + "/main.png", "/home/rijumone/Kitchen/tineye/work-with-image/a.png")
copyfile(filePath + "/" + directory + "/main_1.png", "/home/rijumone/Kitchen/tineye/work-with-image/b.png")

height = int(height)
result = Image.new("RGB", (1080, 1920 + height))

a = Image.open("a.png")
b = Image.open("b.png")

# result.paste(main_img.crop((0,0,500,500)) ,(0,0,500, 500))
result.paste(a.crop((0,0,1080, height)) ,(0,0,1080, height))

result.paste(b.crop((0,0 ,1080,1920)) , (0, height , 1080, 1920 + height))

result.save("result.png")

# 63
1504675730