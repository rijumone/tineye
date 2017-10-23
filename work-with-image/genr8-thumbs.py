import os

from PIL import Image

# city = "Delhi"
# city = "Mumbai"
city = "Bengaluru"

filePath = "/media/rijumone/BE02-5C63/Download/tmp/data/" + city

for directory in os.listdir(filePath):
	# int(directory) >= 1508260426 and 
    if os.path.isfile(filePath + "/" + directory + "/main.png"):
    	if os.path.isfile(filePath + "/" + directory + "/full_size_thumb.png"):
    		os.remove(filePath + "/" + directory + "/full_size_thumb.png")
    	print "================================================"
    	print directory
    	try:			
			img = Image.open(filePath + "/" + directory + "/main.png")
			width = img.size[0]
			img3 = img.crop(
			    (
			        0,
			        0,
			        width,
			        1083
			    )
			)
			basewidth = 300
			wpercent = (basewidth/float(img.size[0]))
			hsize = int((float(1083)*float(wpercent)))
			img3 = img3.resize((basewidth,hsize), Image.ANTIALIAS)
			img3.save(filePath + "/" + directory + "/thumb.png")
        except Exception as e:
            pass
        else:
        	pass

