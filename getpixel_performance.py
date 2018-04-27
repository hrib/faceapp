import win32gui
from PIL import ImageGrab
import numpy as np
import pyautogui
from PIL import Image
import pandas as pd

import win32gui
import win32ui 
import win32con

import time


def ScreenToMemory_win(x,y,w,h):

    wDC = win32gui.GetWindowDC(i_desktop_window_id)
    dcObj=win32ui.CreateDCFromHandle(wDC)
    cDC=dcObj.CreateCompatibleDC()
    dataBitMap = win32ui.CreateBitmap()
    
    dataBitMap.CreateCompatibleBitmap(dcObj, w, h)
    cDC.SelectObject(dataBitMap)
    cDC.BitBlt((0,0),(w, h) , dcObj, (x,y), win32con.SRCCOPY)
    #dataBitMap.SaveBitmapFile(cDC, 'win_image.png')
    #im = dataBitMap.GetBitmapBits(False)
    
    bmpinfo = dataBitMap.GetInfo()
    bmpstr = dataBitMap.GetBitmapBits(True)
    im = Image.frombuffer('RGB', (bmpinfo['bmWidth'], bmpinfo['bmHeight']), bmpstr, 'raw', 'BGRX', 0, 1)
    im = np.array(im)
    # Free Resources
    dcObj.DeleteDC()
    cDC.DeleteDC()
    win32gui.ReleaseDC(i_desktop_window_id, wDC)
    win32gui.DeleteObject(dataBitMap.GetHandle())
    return im 

def ScreenToMemory_PIL(x,y,w,h):
    im = ImageGrab.grab(bbox=(x,y,x+w,y+h)) # X1,Y1,X2,Y2
    #im = im.convert('RGB')
    im = np.array(im)
    return im

def ScreenToMemory_autogui(x,y,w,h):
    im = pyautogui.screenshot(region=(x,y,w,h)) 
    im = np.array(im)
    return im





def SaveScreen_win(x,y,w,h):
    #hwnd = win32gui.FindWindow(None, windowname)
    wDC = win32gui.GetWindowDC(i_desktop_window_id)
    dcObj=win32ui.CreateDCFromHandle(wDC)
    cDC=dcObj.CreateCompatibleDC()
    dataBitMap = win32ui.CreateBitmap()
    dataBitMap.CreateCompatibleBitmap(dcObj, w, h)
    cDC.SelectObject(dataBitMap)
    cDC.BitBlt((0,0),(w, h) , dcObj, (x,y), win32con.SRCCOPY)
    dataBitMap.SaveBitmapFile(cDC, 'win_image.png')
    # Free Resources
    dcObj.DeleteDC()
    cDC.DeleteDC()
    win32gui.ReleaseDC(i_desktop_window_id, wDC)
    win32gui.DeleteObject(dataBitMap.GetHandle())
    return

def SaveScreen_PIL(x,y,w,h):
    im = ImageGrab.grab(bbox=(x,y,x+w,y+h)) # X1,Y1,X2,Y2
    im.save('scrshot_pil.png')
    return

def SaveScreen_autogui(x,y,w,h):
    pyautogui.screenshot('scrshot_autogui.png', region=(x,y,w,h)) 
    return




def CorPixel_autogui(x,y):
    im = pyautogui.screenshot(region=(x,y,1,1))
    im = im.getpixel((0, 0))
    return im

def CorPixel_PIL(x,y):
    #30ms pra achar 1 pixel
    im = ImageGrab.grab(bbox=(x,y,x+1,x+1)) # X1,Y1,X2,Y2
    #im = im.convert('RGB')
    im = np.array(im)
    #im.save('scrshot_teste.png')
    #x = int(x)
    #y = int(y)
    #cor = im[y][x]
    return im

def CorPixel_win(x,y):
    #30ms pra achar 1 pixel
    x = int(x)
    y = int(y)
    i_desktop_window_dc = win32gui.GetWindowDC(i_desktop_window_id)
    cor = win32gui.GetPixel(i_desktop_window_dc, x, y)
    win32gui.ReleaseDC(i_desktop_window_id, i_desktop_window_dc)
    return cor



from ctypes import windll
dc= windll.user32.GetDC(0)
def CorPixel_ctype(x,y):
    return windll.gdi32.GetPixel(dc,x,y)
    #return windll.gdi32.GetPixel(dc,x,y)


i_desktop_window_id = win32gui.GetDesktopWindow()
time.sleep(3)

x = 10
y = 10
w = 1000
h = 700

#teste de GetPixel, considerando que e' necessario screenshot
#se ja tiver screenshot salvo na memoria, e' so' acessar o pixel cor = im[y][x]
print(CorPixel_win(x,y)) #63ms  / #30ms - 60ms
print(CorPixel_PIL(x,y)) #40-70 / #40-70ms
print(CorPixel_autogui(x,y)) #40-70 / #50-70ms
print(CorPixel_ctype(x,y)) #30-62ms

#teste para capturar e salvar screenshot
SaveScreen_win(x,y,w,h) #70-92 / #65ms
SaveScreen_PIL(x,y,w,h) #95-120ms / #95ms
SaveScreen_autogui(x,y,w,h) #95-120ms / #85-105ms

#teste para capturar, mas nao salvar. Fica na memoria.
mem_win = ScreenToMemory_win(x,y,w,h) #35-66 (tem pequenas diferencas na cor do pixel)
mem_PIL = ScreenToMemory_PIL(x,y,w,h) #43-68ms / #67ms
mem_autogui = ScreenToMemory_autogui(x,y,w,h) #46-63ms / #45ms