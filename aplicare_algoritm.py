# -*- coding: utf-8 -*-
"""
Created on Tue Apr  2 13:57:26 2024

@author: Liuda
"""
import librosa
import numpy as np
from tensorflow.keras.models import load_model
import mysql.connector
from pydub import AudioSegment
import io

from sklearn.preprocessing import StandardScaler
import joblib
from mysql.connector import errorcode
import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '2'

scaler = StandardScaler()
scaler = joblib.load('scaler_3cat.pkl')


try:
  mydb=mysql.connector.connect(host="localhost",port="5222",user="root",password="",database="test")
except mysql.connector.Error as err:
  if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
    print(err)
cursor=mydb.cursor()
try:
    query = "SELECT semnal FROM tabel_audio_samples WHERE id = (SELECT MAX(id) FROM tabel_audio_samples)"
    cursor.execute(query)
    audio_data = cursor.fetchone()[0]
    
    AudioSegment.from_file(io.BytesIO(audio_data), format="webm").export("temp_audio.wav", format="wav")
    print("Audio recording retrieved successfully.")
except Exception as e:
    print("Error retrieving audio recording:", e)

cursor.close()
mydb.close()

def extract_features(data, sample_rate):
    result = np.array([])

    # Zero Crossing Rate
    zcr = np.mean(librosa.feature.zero_crossing_rate(y=data).T, axis=0)
    result = np.hstack((result, zcr))

    # Chroma_stft
    stft = np.abs(librosa.stft(data))
    chroma_stft = np.mean(librosa.feature.chroma_stft(S=stft, sr=sample_rate).T, axis=0)
    result = np.hstack((result, chroma_stft))

    # MFCC
    mfcc = np.mean(librosa.feature.mfcc(y=data, sr=sample_rate).T, axis=0)
    result = np.hstack((result, mfcc))

    # Root Mean Square (RMS)
    rms = np.mean(librosa.feature.rms(y=data).T, axis=0)
    result = np.hstack((result, rms))

    # Mel Spectrogram
    mel = np.mean(librosa.feature.melspectrogram(y=data, sr=sample_rate).T, axis=0)
    result = np.hstack((result, mel))

    return result


def update_database(emotia):

    mydb = mysql.connector.connect(
        host="localhost",
        port="5222",
        user="root",
        password="",
        database="test"
    )
    cursor = mydb.cursor()
    
    try:
        cursor.execute("UPDATE tabel_audio_samples SET rezultat = %s WHERE id = (SELECT MAX(id) FROM tabel_audio_samples)", (emotia,))
        mydb.commit()
        print("Update successful.")
    except Exception as e:
        print("Error updating database:", e)
        mydb.rollback()

    cursor.close()
    mydb.close()


def main(audio_path):
    try:
        # Load audio file
        data, sample_rate = librosa.load(audio_path, sr=None)

        # Extract features from audio
        audio_features = extract_features(data, sample_rate)
        # Update MySQL table with emotion result
        model = load_model("model_3cat.h5")
        print(audio_features.shape)
        #print(model.summary())
        print(scaler)
        audio_features = scaler.transform(audio_features.reshape(1, -1)).reshape(1, -1, 1)
        audio_features=np.array(audio_features)
        predicted_emotion = model.predict(audio_features, verbose=0)
        print(predicted_emotion)
        emotia = np.argmax(predicted_emotion)
        emotia = int(emotia)
        update_database(emotia)
    except Exception as e:
        print("Error during prediction:", e)


if __name__ == "__main__":
    audio_path = "temp_audio.wav"  
    main(audio_path)
    
    
