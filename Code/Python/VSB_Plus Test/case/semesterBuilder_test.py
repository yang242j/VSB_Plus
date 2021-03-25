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
        self.driver.maximize_window()
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
        # Get screenshot for every test
        self.driver.get_screenshot_as_file(path+'/resultpang/prereq/%s_%s.png' % (casedata['module'],casedata['id']))
        # Compare the test result with expection
        self.assertIn(self.assert_value, self.result)
        
    # def test_drag_drop(self):
    #     # Set the datas
    #     self.sid = '200362878'
    #     self.pwd = "200362878"
    #     self.actions = ['in']

    #     self.suc = '1'
    #     self.assert_value = int('1')
 
    #     # Print the input data with logs
    #     # self.logs.info_log('Input Data: SID: %s, password: %s, add course: %s,suc: %s, assert: %s' % (self.sid, self.pwd, self.addCourse, self.suc, self.assert_value))
    #     semesterDriver = self.login.signIn(self.sid, self.pwd)
    #     self.builder = SemesterBuilder(semesterDriver)

    #     for action in self.actions:
    #         if action == 'in':
    #             self.builder.dragIn()
    #         elif action == 'out':
    #             self.builder.dropOut()
    #         else: raise NameError('Incorrect input action') 
        
    #     self.result = self.builder.getCourseList() 
    #     self.assertEqual(len(self.result), self.assert_value)

    def tearDown(self):
        self.driver.quit()
