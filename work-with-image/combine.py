# http://matthiaseisen.com/pp/patterns/p0202/

from PIL import Image
import sys, time
import os

# filePath = "/media/rijumone/Seagate BUP Slim1/bkp/data/Delhi"
filePath = "/media/rijumone/3AB8-1F06/Download/tmp/data/Delhi"

for directory in os.listdir(filePath):
    # print directory
    if os.path.isfile(filePath + "/" + directory + "/main.png") and os.path.isfile(filePath + "/" + directory + "/main_1.png"):

        copyfile(filePath + "/" + directory + "/main.png", "/home/rijumone/Kitchen/tineye/work-with-image/main.png")
        copyfile(filePath + "/" + directory+"/main_1.png", "/home/rijumone/Kitchen/tineye/work-with-image/main_1.png")

        img = Image.open("main.png")

        # print "generating cropped image from main image bottom"

        width = img.size[0]
        height = img.size[1]
        img3 = img.crop(
            (
                0,
                height - 789,
                width,
                height - 200
            )
        )
        img3.save("main_cropped.png")

        zero_norm_pp = 1
        current_height = -1
        ctr = 0
        lowestVals = {"a":9999999999,"b":9999999999,"c":9999999999,"d":9999999999}
        while True :
        # while zero_norm_pp > 0.07 :
            # keep generating images and comparing
            # print "now generating cropped image from main image 1 top"
            
            current_height+=1
            
            img = Image.open("main_1.png")

            width = img.size[0]
            height = img.size[1]
            img3 = img.crop(
                (
                    0,
                    current_height,
                    width,
                    current_height + 589
                )
            )
            img3.save("main_cropped_1.png")
            try:
                returnVals = main("main_cropped.png","main_cropped_1.png")
            except Exception as e:
                break
            else:
                pass
            finally:
                pass
            
            if lowestVals["a"] > returnVals[0]:
                lowestVals["a"] = returnVals[0]
            if lowestVals["b"] > returnVals[1]:
                lowestVals["b"] = returnVals[1]
            if lowestVals["c"] > returnVals[2]:
                lowestVals["c"] = returnVals[2]
            if lowestVals["d"] > returnVals[3]:
                lowestVals["d"] = returnVals[3]
            
            ctr+=1
            print filePath + "/" + directory
            print returnVals
            print lowestVals
            print "============"
            print ctr
            print "===================================================================================="
            if ctr > 1331: # image end reached
                break

        with open('data.csv','a') as a:
        # a.writelines("Name,Age\n")
            a.writelines(directory + "," + str(lowestVals["a"]) + ","  + str(lowestVals["b"]) + ","  + str(lowestVals["c"]) + ","  + str(lowestVals["d"]) + "\n") 

# 0.0384521604938

# {'a': 491480.83431952458, 'c': 396102.0, 'b': 0.77262282952827233, 'd': 0.62268439916996798} Renuka
# {'a': 131340.75842696629, 'c': 6459.0, 'b': 0.20647166953871329, 'd': 0.010153744576495} Sharon
# {'a': 11003.5, 'c': 1100.0, 'b': 0.017297836886122114, 'd': 0.0017292334779601332} Pankhuri
