from common.funCourseDB import Login_test
from common.funAcademic import AcademicBuilder
import ddt,unittest,os,time
from util import log
from selenium import webdriver
from util.gettestdata import huoqu_test
path=os.getcwd()
case_path=path+'\\data\\case.xlsx'
casedata=huoqu_test(case_path,4)

@ddt.ddt
class TestAcademicBuilder(unittest.TestCase):
    def setUp(self):
        self.logs=log.log_message()
        self.driver=webdriver.Chrome()
        self.driver.maximize_window()
        self.driver.implicitly_wait(10)
        self.login=Login_test(self.driver)
    
    @ddt.data(*casedata)
    def test_drag_drop(self, casedata):
        # Set the datas
        self.sid = casedata['sid']
        self.pwd = casedata['pwd']
        self.actions = eval(casedata['course'])
        
        self.suc = casedata['suc']
        self.assert_value = casedata['assert']
 
        # Print the input data with logs
        self.logs.info_log('Input Data: SID: %s, password: %s, add course: %s,suc: %s, assert: %s' % (self.sid, self.pwd, self.actions, self.suc, self.assert_value))
        
        # Login in with the provided acount
        academicDriver = self.login.signIn(self.sid, self.pwd)
        # Get into the academic builder page with login driver
        self.builder = AcademicBuilder(academicDriver)

        # Drag courses in to specific term
        termNum = 1
        for action in self.actions:
            self.builder.dragIn(action, termNum)
            termNum += 1

        # Get screenshot for every test
        self.driver.get_screenshot_as_file(path+'/resultpang/acadmic/%s_%s.png' % (casedata['module'],casedata['id']))

        # Compare the result and expect value
        self.result = self.builder.getResult(self.suc) 
        self.assertIn(self.assert_value, self.result)

    def tearDown(self):
        self.driver.quit()
