from common.funCourseDB import Login_test
from common.funSemster import SemesterBuilder
import ddt,unittest,os,time
from util import log
from selenium import webdriver
from util.gettestdata import huoqu_test
path=os.getcwd()
case_path=path+'\\data\\case.xlsx'
casedata=huoqu_test(case_path,3)

@ddt.ddt
class TestSemesterBuilder(unittest.TestCase):
    def setUp(self):
        self.logs=log.log_message()
        self.driver=webdriver.Chrome()
        self.driver.implicitly_wait(10)
        self.login=Login_test(self.driver)
    
    @ddt.data(*casedata)
    def test_prereq(self, casedata):
        # Set the datas
        self.sid = casedata['sid']
        self.pwd = casedata['pwd']
        self.addCourse = casedata['course']
        self.suc = casedata['suc']
        self.assert_value = casedata['assert']
 
        # Print the input data with logs
        self.logs.info_log('Input Data: SID: %s, password: %s, add course: %s,suc: %s, assert: %s' % (self.sid, self.pwd, self.addCourse, self.suc, self.assert_value))
        semesterDriver = self.login.signIn(self.sid, self.pwd)
        self.builder = SemesterBuilder(semesterDriver)
        self.result = self.builder.addCourse(self.suc, self.addCourse)
        self.assertIn(self.assert_value, self.result)
        
    def tearDown(self):
        self.driver.quit()
