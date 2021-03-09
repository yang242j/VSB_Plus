""" 
@author: Xinyu Liu
@file: gettestdata.py 
@time: 2021/3/8 11:43 
"""
import xlrd
from util import log
# import log
logs=log.log_message()
def huoqu_test(filepath,index):
    try:
        file = xlrd.open_workbook(filepath)
        # print("ok")
        me = file.sheets()[index]
        nrows = me.nrows
        listdata = []
        for i in range(1, nrows):
            dict_canshu = {}
            dict_canshu['id']=me.cell(i,0).value
            dict_canshu.update(eval(me.cell(i,2).value))
            dict_canshu.update(eval(me.cell(i,3).value))
            listdata.append(dict_canshu)
        return listdata
    except Exception as e:
        logs.error_log('Fail to get the test datas，reason：%s'%e)

