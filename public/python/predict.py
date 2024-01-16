import pandas as pd
import numpy as np
from datetime import datetime
from math import sqrt
from numpy import concatenate
from matplotlib import pyplot
from pandas import read_csv
from pandas import DataFrame
from pandas import concat
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import MinMaxScaler
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import mean_squared_error
from keras.models import Sequential,load_model
from keras.layers import Dense
from keras.layers import LSTM
import json
import sys
def testing(urlModel,urlFile,id):
  column_data_types = {'Column1': float, 'Column2': float, 'Column3': float, 'Column4': float, 'Column5': float, 'Column6': float, 'Column7':float}
  dataset = read_csv(urlFile, header=0, on_bad_lines='skip',sep=';', dtype=column_data_types)
  values = dataset.values
  data = values[:,  1:]
  scaler = MinMaxScaler()
  scaled = scaler.fit_transform(data)
  reframed = series_to_supervised(scaled, 1, 1)
  reframed.drop(reframed.columns[[6,7,8,10,11]], axis=1, inplace=True)
  values = reframed.values
  test = values[:, :]
  test_X, test_y = test[:, :-1], test[:, -1]
  test_X = test_X.reshape((test_X.shape[0], 1, test_X.shape[1]))
  model = load_model(urlModel)
  yhat = model.predict(test_X)
  test_X = test_X.reshape((test_X.shape[0], test_X.shape[2]))
  inv_yhat = concatenate((yhat, test_X[:, 1:]), axis=1)
  inv_yhat = scaler.inverse_transform(inv_yhat)
  inv_yhat = inv_yhat[:,0]

  inv_test_y = test_y.reshape((len(test_y), 1))
  inv_test_y = concatenate((inv_test_y, test_X[:, 1:]), axis=1)
  inv_test_y = scaler.inverse_transform(inv_test_y)
  inv_test_y = inv_test_y[:,0]
  #save yhat to json file
  #concate inv_yhat and inv_test_X
  data = []
  for i in range(len(inv_yhat)):
    data.append([inv_yhat[i],inv_test_y[i]])
  nameResult = 'result-'+ id +'.json'
  with open(nameResult, 'w') as json_file:
    json.dump(data, json_file)
  rmse = sqrt(mean_squared_error(inv_test_y, inv_yhat))
  print(nameResult + '~' + str(rmse))
  # pyplot.plot(inv_test_y, label="original")
  # pyplot.plot(inv_yhat, label="predict")
  # pyplot.legend(loc="best")
  # pyplot.show()

def series_to_supervised(data, n_in=1, n_out=1, dropnan=True):
    n_vars = 1 if type(data) is list else data.shape[1]
    df = DataFrame(data)
    cols, names = list(), list()
    # input sequence (t-n, ... t-1)
    for i in range(n_in, 0, -1):
        cols.append(df.shift(i))
        names += [('var%d(t-%d)' % (j+1, i)) for j in range(n_vars)]
    # forecast sequence (t, t+1, ... t+n)
    for i in range(0, n_out):
        cols.append(df.shift(-i))
        if i == 0:
            names += [('var%d(t)' % (j+1)) for j in range(n_vars)]
        else:
            names += [('var%d(t+%d)' % (j+1, i)) for j in range(n_vars)]
    # put it all together
    agg = concat(cols, axis=1)
    agg.columns = names
    # drop rows with NaN values
    if dropnan:
        agg.dropna(inplace=True)
    return agg


#main function
if __name__ == '__main__':
  # predict('modelOpen-20231106150939.h5','TestData/30.xlsx',1000)
  urlModel = sys.argv[1]
  urlFile = sys.argv[2]
  id = sys.argv[3]
  testing(urlModel,urlFile,id)