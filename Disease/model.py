import tensorflow as tf
import numpy as np
import cv2
import json
import sys
import os

# ==========================
# Arguments
# ==========================

crop = sys.argv[1]
image_path = sys.argv[2]

image_path = image_path.replace("\\", "/")

# ==========================
# Select Model
# ==========================

if crop == "Wheat":
    MODEL_PATH = "model_wheat/model.keras"
    LABEL_PATH = "model_wheat/labels.json"
    IMG_SIZE = (160,160)

elif crop == "Rice":
    MODEL_PATH = "model_rice/model.keras"
    LABEL_PATH = "model_rice/labels.json"
    IMG_SIZE = (224,224)

elif crop == "Maize":
    MODEL_PATH = "model_maize/best_model.keras"
    LABEL_PATH = "model_maize/labels.json"
    IMG_SIZE = (224,224)

else:
    print(json.dumps({
        "status":"error",
        "message":"Invalid Crop"
    }))
    sys.exit()

# ==========================
# Load Model
# ==========================

model = tf.keras.models.load_model(MODEL_PATH)

with open(LABEL_PATH,"r",encoding="utf-8") as f:
    class_names = json.load(f)

# ==========================
# Read Image
# ==========================

img = cv2.imread(image_path)

if img is None:
    print(json.dumps({
        "status":"error",
        "message":"Image not found"
    }))
    sys.exit()

img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)

img = cv2.resize(img, IMG_SIZE)

img = img.astype(np.float32)

# MobileNetV2 preprocessing
img = tf.keras.applications.mobilenet_v2.preprocess_input(img)

img = np.expand_dims(img, axis=0)

# ==========================
# Predict
# ==========================

prediction = model.predict(img, verbose=0)

index = int(np.argmax(prediction))

confidence = float(np.max(prediction))

label = class_names[index]
print("\n===== ALL CLASS PROBABILITIES =====")

for i, class_name in enumerate(class_names):
    print(
        class_name,
        "->",
        round(float(prediction[0][i]) * 100, 2),
        "%"
    )

print("===================================\n")

# ==========================
# Output
# ==========================

print(json.dumps({
    "status":"success",
    "class":label,
    "confidence":round(confidence*100,2)
}))