import unittest
from time import sleep
from selenium import webdriver
from selenium.webdriver.common.by import By


class courseSearch(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Chrome(executable_path=r'C:\Users\xinyuliu\Desktop\chromedriver.exe')

    def test_search_in_courseDB(self):
        driver = self.driver
        driver.implicitly_wait(10)
        driver.get('http://15.223.123.122/')
        # sleep(1)
        driver.find_element_by_link_text("Let's Go").click()
        sleep(1)
        driver.find_element_by_id('quickLink').click()
        # sleep(3)
        # driver.find_element(By.XPATH, "//*[@id='course_input']").click().send_keys("CHEM 104")
        driver.find_element(By.ID, "course_input").send_keys("CHEM 104")
        driver.find_element(By.XPATH, "//*[@id='course_search']/tbody/tr/td[1]/input[2]").click()
        sleep(5)
        titleEle = driver.find_element(By.ID, "title")
        self.assertIn("CHEM 104", titleEle.text)

        fullName = driver.find_element(By.ID, "fullName")
        self.assertIn("General Chemistry I", fullName.text)
    
    def test_search_in_courseDB2(self):
        driver = self.driver
        driver.implicitly_wait(10)
        driver.get('http://15.223.123.122/')
        # sleep(1)
        driver.find_element_by_link_text("Let's Go").click()
        sleep(1)
        driver.find_element_by_id('quickLink').click()
        # sleep(3)
        # driver.find_element(By.XPATH, "//*[@id='course_input']").click().send_keys("CHEM 104")
        driver.find_element(By.ID, "course_input").send_keys("CHEM 104")
        driver.find_element(By.XPATH, "//*[@id='course_search']/tbody/tr/td[1]/input[2]").click()
        sleep(5)
        titleEle = driver.find_element(By.ID, "title")
        self.assertIn("CHEM 104", titleEle.text)

        fullName = driver.find_element(By.ID, "fullName")
        self.assertIn("General Chemistry I", fullName.text)
        
    def tearDown(self):
        self.driver.close()
        pass


if __name__ == "__main__":
    unittest.main()