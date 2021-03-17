import yaml,os, time
path=os.getcwd()
from selenium.webdriver.support.select import Select
from util import log
class SemesterBuilder:#封装
    def __init__(self,driver):#
        self.driver=driver
        self.logs = log.log_message()
        self.file=open(path+"\\data\\page_data.yaml", "r",encoding= "utf-8")
        self.data=yaml.load(self.file)
        self.file.close()

        #Load the datas
        self.showNavBar = self.data['semesterBuilder'].get('showNavBar')
        self.semsterPage=self.data['semesterBuilder'].get('semsterPage')
        self.termSele=self.data['semesterBuilder'].get('termSele')
        self.courseSele=self.data['semesterBuilder'].get('courseSele')
        self.sumbitBtn=self.data['semesterBuilder'].get('sumbitBtn')
        self.searchMsg=self.data['semesterBuilder'].get('searchMsg')
        self.cardIdSuffix=self.data['semesterBuilder'].get('cardIdSuffix')

        # Get to the semester builder page
        self.driver.find_element_by_xpath(self.showNavBar).click()
        self.driver.find_element_by_xpath(self.semsterPage).click()

    # Selecte the term that want to add course to
    def setTerm(self, term):
        try:
            termSelect = self.driver.find_element_by_id(self.termSele)
            Select(termSelect).select_by_value(term)
        except Exception as e:
            self.logs.error_log('Fail to set term，reason：%s'%e)

    # Using search course function to test the prereq match
    def addCourse(self,suc, course):
        try:
            self.driver.find_element_by_id(self.courseSele).clear()
            self.driver.find_element_by_id(self.courseSele).send_keys(course)
            self.driver.find_element_by_xpath(self.sumbitBtn).click()
            time.sleep(1)
            if suc=='1':
                 self.search_res = self.driver.find_element_by_id(self.searchMsg).text
                 return self.search_res
            if suc=='0':
                alert = self.driver.switch_to_alert()
                self.search_err = alert.text
                alert.accept()
                return self.search_err
        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            # self.driver.quit()
            pass

    def dragDrop(self, course):
        pass
