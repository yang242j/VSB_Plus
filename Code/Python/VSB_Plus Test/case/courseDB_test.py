from common.funCourseDB import CourseDB_test
import ddt,unittest,os,time
from util import log
from selenium import webdriver
from util.gettestdata import huoqu_test
path=os.getcwd()
case_path=path+'\\data\\case.xlsx'
casedata=huoqu_test(case_path,0)
faultyTest_data = huoqu_test(case_path,1)
@ddt.ddt
class TestCourseSearch(unittest.TestCase):
    def setUp(self):
        self.logs=log.log_message()
        self.driver=webdriver.Chrome()
        self.driver.maximize_window()
        self.driver.implicitly_wait(10)
        self.courseDB=CourseDB_test(self.driver)

    @ddt.data(*casedata)
    def test_searchCourse(self,casedata):
        # Set the test parameters
        self.name=casedata['short_name']
        self.suc=casedata['suc']
        self.assert_value = casedata['assert']
        
        # Run the test
        re_data, chartExist = self.courseDB.search(self.suc,self.name)
        # Get screenshot and record for every test
        time.sleep(1)
        self.driver.get_screenshot_as_file(path+'/resultpang/searchCourse/%s_%s.png' % (casedata['module'],casedata['id']))
        self.logs.info_log('Input Data: short_name:%s,suc:%s,assert:%s' % (self.name, self.suc, self.assert_value))
        # Compare the test result with excpeted
        self.assertEqual(re_data, self.assert_value)
        self.assertTrue(chartExist) if self.suc == '1' else self.assertFalse(chartExist)
        

    @ddt.data(*faultyTest_data)
    def test_faultyFilter(self,faultyTest_data):
        self.faulty = faultyTest_data['faulty']
        self.suc = faultyTest_data['suc']
        self.assert_value = faultyTest_data['assert']
        # Run the test with driver
        res_list = self.courseDB.setFacFilter(self.faulty)
        # Get screenshot and record for every test
        self.driver.get_screenshot_as_file(path+'/resultpang/faultyFilter/%s_%s.png' % (faultyTest_data['module'],faultyTest_data['id']))
        self.logs.info_log('Input Data: %s,suc:%s,assert:%s' % (self.faulty, self.suc, self.assert_value))
        # Compare the test result with excpeted
        for course in res_list:
            self.assertIn(self.assert_value, course)

    def tearDown(self):
        self.driver.quit()
