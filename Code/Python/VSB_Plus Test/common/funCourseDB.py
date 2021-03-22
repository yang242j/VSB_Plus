import yaml,os, time
path=os.getcwd()
from util import log
class CourseDB_test:#封装
    def __init__(self,driver):#
        self.driver=driver
        self.logs = log.log_message()
        self.file=open(path+"\\data\\page_data.yaml", "r",encoding= "utf-8")
        self.data=yaml.load(self.file, Loader=yaml.FullLoader)
        self.file.close()
        self.lo_url=self.data['courseDB'].get('url')
        self.input_box=self.data['courseDB'].get('input_box')
        self.title=self.data['courseDB'].get('selectedTitle')
        self.selectButton=self.data['courseDB'].get('clickButton')
        self.message=self.data['courseDB'].get('message')
        self.fullName=self.data['courseDB'].get('fullName')
        self.faultyBtn = self.data['courseDB'].get('faultyBtn')
        self.faultySelected = self.data['courseDB'].get('faultySelected')
        self.courseList = self.data['courseDB'].get('courseList')
        self.chart = self.data['courseDB'].get('chart')
        self.driver.get(self.lo_url)
        time.sleep(1)

    def search(self,suc,short_name):
        try:
            self.driver.find_element_by_id(self.input_box).clear()
            self.driver.find_element_by_id(self.input_box).send_keys(short_name)
            self.driver.find_element_by_xpath(self.selectButton).click()
            if suc=='1':
                 self.search_res = self.driver.find_element_by_id(self.fullName).text
                 charts = self.driver.find_elements_by_id(self.chart)
                 self.chartExist = True if len(charts) == 1 else False
                 return self.search_res, self.chartExist
            if suc=='0':
                self.search_err=self.driver.find_element_by_id(self.message).text
                return self.search_err, False
        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            pass
        #     self.driver.quit()

    def setFacFilter(self, faultyName):
        try:
            faultys = self.driver.find_elements_by_class_name(self.faultyBtn)
            setFac = None
            for faulty in faultys:
                if faulty.text == faultyName: 
                    setFac = faulty
                    break
            faulty.click()
            courseList = self.driver.find_elements_by_class_name(self.courseList)
            result = [cour.text for cour in courseList]
            return result
        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            pass
        #     self.driver.quit()

    def clearFacFilter(self):
        try:
            selecteds = self.driver.find_elements_by_class_name(self.faultySelected)
            for selected in selecteds:
                selected.click()
        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            pass
            # self.driver.quit()

# For the login methods
class Login_test:

    def __init__(self, driver):
        # Get the instances
        self.driver=driver
        self.logs = log.log_message()
        self.file=open(path+"\\data\\page_data.yaml", "r",encoding= "utf-8")
        self.data=yaml.load(self.file, Loader=yaml.FullLoader)
        self.file.close()

        # Setup the parameters
        self.lo_url=self.data['login'].get('url')
        self.sid_input=self.data['login'].get('sid_box')
        self.pwd_input=self.data['login'].get('pwd')
        self.loginBtn=self.data['login'].get('loginBtn')
        # self.sidMsg = self.data['login'].get('sidErrorMsg')
        # self.psdMsg = self.data['login'].get('psdErrorMsg')
        self.sucMsg = self.data['login'].get('sucMsg')
        self.errorMsg = self.data['login'].get('errorMsg')
        self.pieGraph = self.data['login'].get('pieGraph')
        self.lineGraph = self.data['login'].get('lineGraph')

        # Open the login page  
        self.driver.get(self.lo_url)

    def login(self, SID, pwd, suc):
        try:
            driver = self.driver
            # Input the sid into boxes
            driver.find_element_by_xpath(self.sid_input).clear()
            driver.find_element_by_xpath(self.sid_input).send_keys(SID)
            
            #Input the password into boxes
            driver.find_element_by_xpath(self.pwd_input).clear()
            driver.find_element_by_xpath(self.pwd_input).send_keys(pwd)

            #Click login button
            driver.find_element_by_xpath(self.loginBtn).click()

            if suc == '1':
                return driver.find_element_by_id(self.sucMsg).text
            else:
                msgs = driver.find_elements_by_class_name(self.errorMsg)
                errorMsg = ''
                for msg in msgs:
                    errorMsg += (msg.text).strip()
                return errorMsg

        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            pass

    def signIn(self, SID, password):
        driver = self.driver
        # Input the sid into boxes
        driver.find_element_by_xpath(self.sid_input).clear()
        driver.find_element_by_xpath(self.sid_input).send_keys(SID)
        
        #Input the password into boxes
        driver.find_element_by_xpath(self.pwd_input).clear()
        driver.find_element_by_xpath(self.pwd_input).send_keys(password)
        #Click login button
        driver.find_element_by_xpath(self.loginBtn).click()
        if self.pieShow(): return driver
        else: print("sign in fail")

    def pieShow(self):
        driver = self.driver
        pieGraphs = driver.find_elements_by_id(self.pieGraph)
        if len(pieGraphs) == 1: return True
        else: return False

    def lineShow(self):
        driver = self.driver
        lineGraphs = driver.find_elements_by_id(self.lineGraph)
        if len(lineGraphs) == 1: return True
        else: return False