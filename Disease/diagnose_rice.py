import tensorflow as tf
import numpy as np
import os
import cv2
from collections import Counter

# ==============================
# Paths
# ==============================

MODEL_PATH = "model_rice/model.keras"
TEST_HEALTHY_PATH = "Dataset_AI/Rice/test/healthy"

# ==============================
# Load Model
# ==============================

model = tf.keras.models.load_model(MODEL_PATH)

class_names = [
    "bacterial_leaf_blight",
    "brown_spot",
    "healthy",
    "leaf_blast",
    "leaf_scald",
    "narrow_brown_spot"
]

# ==============================
# Counters
# ==============================

results = []

total = 0
correct = 0

# ==============================
# Read Healthy Images
# ==============================

files = os.listdir(TEST_HEALTHY_PATH)

for filename in files:

    path = os.path.join(
        TEST_HEALTHY_PATH,
        filename
    )

    img = cv2.imread(path)

    if img is None:
        continue

    img = cv2.cvtColor(
        img,
        cv2.COLOR_BGR2RGB
    )

    img = cv2.resize(
        img,
        (224, 224)
    )

    img = img.astype(
        np.float32
    )

    img = tf.keras.applications.mobilenet_v2.preprocess_input(
        img
    )

    img = np.expand_dims(
        img,
        axis=0
    )

    prediction = model.predict(
        img,
        verbose=0
    )[0]

    index = np.argmax(prediction)

    predicted_class = class_names[index]

    confidence = float(
        prediction[index]
    ) * 100

    total += 1

    if predicted_class == "healthy":
        correct += 1

    results.append(
        predicted_class
    )

    print(
        f"{filename} -> "
        f"{predicted_class} "
        f"({confidence:.2f}%)"
    )

# ==============================
# Final Summary
# ==============================

counter = Counter(results)

print("\n===================================")
print("RICE HEALTHY CLASS DIAGNOSTIC")
print("===================================")

print(
    f"Total Images Tested : {total}"
)

print(
    f"Correct Healthy     : {correct}"
)

if total > 0:

    accuracy = (
        correct / total
    ) * 100

    print(
        f"Healthy Accuracy    : {accuracy:.2f}%"
    )

print("\nPrediction Distribution:")

for class_name in class_names:

    count = counter.get(
        class_name,
        0
    )

    percentage = (
        count / total * 100
        if total > 0
        else 0
    )

    print(
        f"{class_name:25s} "
        f"{count:4d} "
        f"({percentage:.2f}%)"
    )

print("===================================")