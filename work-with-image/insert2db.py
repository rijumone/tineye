#!/usr/bin/python

import MySQLdb
import os
import re
import traceback

# Open database connection
db = MySQLdb.connect("localhost","root","root","tineye")

# Create a cursor object
cursor = db.cursor()

# city = "Delhi"
# city = "Mumbai"
city = "Bengaluru"

filePath = "/media/rijumone/BE02-5C63/Download/tmp/data/" + city
regex = re.compile(r"[^\d]", re.IGNORECASE)
cnt = 0

for directory in os.listdir(filePath):
	# int(directory) >= 1508260426 and 
	if os.path.isfile(filePath + "/" + directory + "/pytesseract_dump.txt"):
		f_name = ""
		l_name = ""
		age = ""
		sex = "woman"
		active = "1"
		bio = ""
		instagram = "NULL"
		spotify = "NULL"
		school_id = "NULL"
		work_id = "NULL"
		locality_id = "NULL"
		state_id = "3"
		city_id = "3"
		country_id = "1"
		with open(filePath + "/" + directory + "/pytesseract_dump.txt","r") as f:
			print directory
			for line in f:
				# print line
				name_age = line.split(", ")
				if len(name_age) > 1:
					names_list = []
					if f_name is "":
						if " " in name_age[0]:
							names_list = name_age[0].split(" ")
						if len(names_list) > 1:
							f_name = names_list[0]	
							l_name = names_list[1]
						else:	
							f_name = name_age[0] 
					name_age[1] = name_age[1].replace("\n","")
					name_age[1] = regex.sub("", name_age[1])
					if name_age[1].isdigit() and int(name_age[1]) >= 18 and int(name_age[1]) <= 55:
						age = name_age[1]
				if not age:
					name_age = line.split(",")
					# print name_age
					if len(name_age) > 1:
						name_age[1] = name_age[1].replace("\n","")
						# print name_age[1]
						name_age[1] = regex.sub("", name_age[1])
						if name_age[1].isdigit() and int(name_age[1]) >= 18 and int(name_age[1]) <= 55 :
							age = name_age[1]
					# print "not age"
		print "f_name: %s" % f_name
		print "l_name: %s" % l_name
		print "age: %s" % age
		if f_name is not "" and age is not "":		
			# Prepare SQL query to INSERT a record into the database.
			sql = ("INSERT INTO `profiles` (`id`, `first_name`, `last_name`, `age`, `sex`, `active`, `bio`, `instagram`, `spotify`, `school_id`, `work_id`, `locality_id`, `state_id`, `city_id`, `country_id`, `created_at`, `updated_at`) VALUES ('%s', '%s', '%s', '%s', 'woman', '1', NULL, NULL, NULL, NULL, NULL, NULL, '%s', '%s', '%s', NULL, NULL);" %(directory,f_name,l_name,str(age), state_id, city_id, country_id))
			print sql
			try:
			   # Execute the SQL command
			   cursor.execute(sql)
			   # Commit your changes in the database
			   db.commit()
			except:
			   # Rollback in case there is any error
			   print "EXCEPTION!"
			   print(traceback.format_exc())
			   db.rollback()
	
	print "==============="
print cnt
	

# disconnect from server
db.close()
