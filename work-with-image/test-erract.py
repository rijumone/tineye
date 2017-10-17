import os

try:
    import Image
except ImportError:
    from PIL import Image
import pytesseract

# print(pytesseract.image_to_string(Image.open('a.png')))

filePath = "/media/rijumone/BE02-5C63/Download/tmp/data/Delhi"

for directory in os.listdir(filePath):
	# int(directory) >= 1508260426 and 
    if os.path.isfile(filePath + "/" + directory + "/main.png"):
    	print "================================================"
    	print directory
    	try:
			dump = pytesseract.image_to_string(Image.open(filePath + "/" + directory + "/main.png"))
        except Exception as e:
            pass
        else:
        	print(dump)
		with open(filePath + "/" + directory + '/pytesseract_dump.txt','w+') as a:
				a.writelines(dump.encode('utf-8'))
        finally:
            pass
    	


# 1506082595    	