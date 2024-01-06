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
from keras.optimizers import Adam
import sys

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

def train(urlFile,neuron,id,layer,learning_rate):
  try:
    column_data_types = {'Column1': float, 'Column2': float, 'Column3': float, 'Column4': float, 'Column5': float, 'Column6': float, 'Column7':float}
    dataset = read_csv(urlFile, header=0, on_bad_lines='skip',sep=';', dtype=column_data_types)
    values = dataset.values
    latih = values[:,  1:]
    scaler = MinMaxScaler(feature_range=(0, 1))
    scaledLatih = scaler.fit_transform(latih)
    reframedLatih = series_to_supervised(scaledLatih, 1, 1)
    reframedLatih.drop(reframedLatih.columns[[6,7,8,10,11]], axis=1, inplace=True)
    train = reframedLatih.values
    train_X, train_y = train[:, :6], train[:, 6:]
    train_X = train_X.reshape((train_X.shape[0], 1, train_X.shape[1]))
    model = Sequential()
    if(layer==2):
      #split neuron to 2 sep |
      neuron1 = int(neuron.split('-')[0])
      neuron2 = int(neuron.split('-')[1])
      model.add(LSTM(neuron1, input_shape=(train_X.shape[1], train_X.shape[2]),return_sequences=True))
      model.add(LSTM(neuron2))
    else:
      model.add(LSTM(neuron, input_shape=(train_X.shape[1], train_X.shape[2])))
    model.add(Dense(1))
    optimizer = Adam(learning_rate=learning_rate)
    model.compile(loss='mse', optimizer=optimizer)
    model.fit(train_X, train_y, epochs=100, batch_size=72, verbose=0, shuffle=False)
    model.save('model-'+ id +'.h5')
    print('|model-'+ id +'.h5')
  except Exception as e:
    print(e)
    print('Training Failed')
#main function
if __name__ == '__main__':
  urlFile = sys.argv[1]
  neuron = sys.argv[2]
  idModel = sys.argv[3]
  layer = int(sys.argv[4])
  learning_rate = float(sys.argv[5])
  train(urlFile,neuron,idModel,layer,learning_rate)