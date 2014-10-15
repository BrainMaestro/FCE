# -*- coding: utf-8 -*-

import tkinter.messagebox

import tkinter.filedialog
from tkinter import *

import os
import xlrd
import csv

textMsg = "Select a file"
excelName = ""
csvName = ""

def openFile():
    filename = tkinter.filedialog.askopenfilename(parent=root,title=textMsg,filetypes=[('MS excel 97-2003','.xls'), ('MS excel 07','.xlsx')])
    openButton["text"] = str(filename)if filename else textMsg
    global excelName
    excelName = openButton["text"]
    




#show message when extraction is completed
#tkMessageBox.showinfo("title name","Message: Extraction Complete")

def extract():
	global excelName
	global csvName
	if excelName != textMsg:
			# Column Name/Title for 15 different indicators
		header = ['syllabus','outcome','content','grading','overall',
		          'prepared','comprehensive','interesting','relevant',
		          'interactive','character','attitude','participation',
		          'assignment','achievement','technology','library',
		          'support','course','instructor']

		# Directory where FCE survey is located
		#survey_dir = 'C:\\Users\\solomon\\Downloads\\OIRE\\FCE\\surveys'

		# Name of the FCE survey file
		#excelName = 'SAS SUMMER 2014.xlsx'

		# Name of new extracted data file
		csvName = os.path.splitext(excelName)[0]+".csv"
		
		#csvName = csvName+".csv"

		# Get current working directory
		#cur_dir = os.getcwd()

		# Change Working directory to FCE survey directory
		#os.chdir(survey_dir)

		# Open/Read FCE survey file
		workbook = xlrd.open_workbook(excelName)

		# temporary list to hold the extracted data
		survey = []

		# Get names of all worksheets
		sheet_names = workbook.sheet_names()[:-3]  #discard the first and last two sheets

		# Read worksheet and extract
		# total reponse, individual responses, course [code, title, instructor]
		# Add to temporary list varible survey
		for sheet_name in sheet_names:
		    sheet = workbook.sheet_by_name(sheet_name)
		    print(sheet_name)
		    total = int(sheet.cell_value(s_info['total'].row, s_info['total'].col)) # get total response
		    course_code = sheet.cell_value(s_info['course'].row, s_info['course'].col)          # get course code
		    course_title = sheet.cell_value(s_info['title'].row, s_info['title'].col)           # get course title
		    instructor = sheet.cell_value(s_info['instructor'].row, s_info['instructor'].col)   # get instructor name
		    response = get_course(sheet, total)                                                 # get all responses
		    course_survey = FCESurvey(course_code, course_title, instructor, total, response)   # Create an instance of FCESurvey as course_survey
		    survey.append(course_survey)                                                        # Add course_survey to survey list

		# Write survey list to csv file
		with open(csvName, 'wt') as csvfile:
		    writer = csv.writer(csvfile, dialect='excel',delimiter=',', quoting=csv.QUOTE_MINIMAL) # Object of csv file
		    writer.writerow(header) # Write headers(indicator) to file
		    # Write responses to csv file
		    for s in survey:
		        s.csvsave(writer)

		tkinter.messagebox.showinfo("title name","Message: Extraction Complete")


# used to store cell reference in the workbook
class Cell(object):
    def __init__(self, row, col):
        self.row = row
        self.col = col
        
# cell reference to course code in worksheet
course_cell = Cell(3,1)
# cell reference to course title in worksheet
title_cell = Cell(2,1)
# cell reference to instructor name in worksheet
instructor_cell = Cell(2,1)
# cell reference to total response
total_cell = Cell(5,2)
starting_cell = Cell(8, 9)

# Dictionary of the cell references in worksheet
s_info = {
    'course':course_cell,
    'title':title_cell,
    'instructor':instructor_cell,
    'start':starting_cell,
    'total':total_cell
}

# Dictionary value of no and dunno from worksheet
# this values will replace it in the extracted datafile (csv)
non_response = {
    'no':0,
    'dunno':'NA'
    }

class FCESurvey (object):
    total = 0
    def __init__(self,course_code,course_title,instructor,total,response,year='2014', semester='Summer'):
        self.course_code = course_code
        self.couse_title = course_title
        self.instructor = instructor
        self.total = total
        self.response = response        
        self.year = year
        self.semester = semester
    def print_survey(self):
        print('Course: %s   Instructor %s' % (self.course_code, self.instructor))
        keys = list(self.response.keys())
        keys.sort()
        for k in keys:
            print(self.response[k])
    def rprint(self):
#        print 'Course: %s   Instructor %s' % (self.course_code, self.instructor)
        keys = list(self.response.keys())
        keys.sort()
        for i in range(self.total):
            for k in keys:
                print(str(self.response[k][i]) + ',', end=' ')
            print(','.join([self.course_code,self.instructor]))

    # save responses to file(csv)
    def csvsave(self, writer):
        keys = list(self.response.keys())
        keys.sort()
        for i in range(self.total):
            row = []
            for k in keys:
                #row.append(str(self.response[k][i]) + ',',)
                row.append(str(self.response[k][i]),)
            row.append(','.join([self.course_code]))
            row.append(','.join([self.instructor]))
            writer.writerow(row)

# Gets individual survey response
def get_response(sheet, row, col):
    window = 6 # space occupied by individual surveys

    # get the value for the indicator between column window
    # put in NA if values is empty
    for col in range(col, col+window):
        cell_value = sheet.cell_value(row, col)
        if type(cell_value) is float:
            return cell_value
        elif type(cell_value) is str and cell_value in list(non_response.keys()):
            return non_response[cell_value.lower()]
    else:
        return '0'
    
# Get all the responses from the FCE Survey       
def get_course(sheet, total, start_row = 8, start_col = 9):
    window = 6
    #questions = 15
    
    qCourse = 5
    qInstr = 7
    qStud = 6
    space = 4
    
    start_course = start_row
    start_instr = start_row + space + qCourse
    start_stud = start_instr + space + qInstr
    
    course_sheet = {}    
    
    
    for i in range(qCourse+qInstr+qStud):
        course_sheet[i] = []
    # Go Through the responses individually by column windows
    for col in range(start_col, start_col+window*total, window):
        last_index = 0
        tmp_count = 0
        for index, row in enumerate(list(range(start_course, start_course+qCourse)),last_index):
            course_sheet[index].append(get_response(sheet, row,col))
            tmp_count = index +1
        last_index = tmp_count
        for index, row in enumerate(list(range(start_instr, start_instr+qInstr)),last_index):
            course_sheet[index].append(get_response(sheet, row,col))
            tmp_count = index +1
        last_index = tmp_count
        for index, row in enumerate(list(range(start_stud, start_stud+qStud)),last_index):
            course_sheet[index].append(get_response(sheet, row,col))
    return course_sheet

root = Tk()
root.title('FCE file extractor')

openButton = Button(root, text=textMsg, command= openFile)
openButton.pack()

extractor = Button(root, text='Extract !!!', command= extract)
extractor.pack()

root.mainloop()

