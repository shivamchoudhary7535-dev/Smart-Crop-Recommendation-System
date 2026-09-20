import tensorflow as tf
import numpy as np
import os
import cv2
from sklearn.metrics import classification_report, confusion_matrix

MODEL_PATH = "model_rice/model.keras"
TEST_PATH = "Dataset_AI/Rice/test"

model = tf.keras.models.load_model(MODEL_PATH)

class_names = sorted(os.listdir(TEST_PATH))

y_true = []
y_pred = []

for class_index, class_name in enumerate(class_names):

    folder = os.path.join(TEST_PATH, class_name)

    for file in os.listdir(folder):

        path = os.path.join(folder, file)

        img = cv2.imread(path)

        if img is None:
            continue

        img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        img = cv2.resize(img, (224,224))
        img = img.astype(np.float32)
        img = tf.keras.applications.mobilenet_v2.preprocess_input(img)
        img = np.expand_dims(img, axis=0)

        pred = model.predict(img, verbose=0)

        y_true.append(class_index)
        y_pred.append(np.argmax(pred))

print("\n========================")
print("Classification Report")
print("========================\n")

print(classification_report(
    y_true,
    y_pred,
    target_names=class_names
))

print("\n========================")
print("Confusion Matrix")
print("========================\n")

print(confusion_matrix(y_true, y_pred))