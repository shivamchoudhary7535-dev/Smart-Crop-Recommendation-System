import os

# CPU Load Kam Karne ke Liye
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "2"

import tensorflow as tf

# Sirf 2 CPU Threads Use Karega
tf.config.threading.set_intra_op_parallelism_threads(2)
tf.config.threading.set_inter_op_parallelism_threads(2)

import tensorflow as tf
from tensorflow.keras.applications import MobileNetV2
from tensorflow.keras import layers, models
import os
import json

# ==========================
# Dataset Path
# ==========================

DATASET_PATH = "Dataset_AI"

IMG_SIZE = (160,160)

BATCH_SIZE = 8

EPOCHS = 2

print("Loading Dataset...")

train_dataset = tf.keras.preprocessing.image_dataset_from_directory(
    DATASET_PATH,
    validation_split=0.2,
    subset="training",
    seed=123,
    image_size=IMG_SIZE,
    batch_size=BATCH_SIZE
)

validation_dataset = tf.keras.preprocessing.image_dataset_from_directory(
    DATASET_PATH,
    validation_split=0.2,
    subset="validation",
    seed=123,
    image_size=IMG_SIZE,
    batch_size=BATCH_SIZE
)

class_names = train_dataset.class_names

print("\nTotal Classes :", len(class_names))

for c in class_names:
    print(c)

AUTOTUNE = tf.data.AUTOTUNE

train_dataset = train_dataset.prefetch(buffer_size=AUTOTUNE)

validation_dataset = validation_dataset.prefetch(buffer_size=AUTOTUNE)

# ==========================
# MobileNetV2 Base Model
# ==========================

base_model = MobileNetV2(

    input_shape=(160,160,3),

    include_top=False,

    weights='imagenet'

)

# Base Model ko freeze kar do

base_model.trainable = False

# ==========================
# Final AI Model
# ==========================

model = models.Sequential([

    layers.Rescaling(1./255),

    base_model,

    layers.GlobalAveragePooling2D(),

    layers.Dropout(0.3),

    layers.Dense(256, activation='relu'),

    layers.Dense(len(class_names), activation='softmax')

])

# ==========================
# Compile Model
# ==========================

model.compile(

    optimizer='adam',

    loss='sparse_categorical_crossentropy',

    metrics=['accuracy']

)

print("\n✅ MobileNetV2 Model Ready...")

# ==========================
# Start Training
# ==========================

print("\n🚀 Training Started...\n")

history = model.fit(

    train_dataset,

    validation_data=validation_dataset,

    epochs=EPOCHS

)

# ==========================
# Save Model
# ==========================

os.makedirs("model", exist_ok=True)

model.save("model/model.keras")

# ==========================
# Save Labels
# ==========================

with open("model/labels.json", "w", encoding="utf-8") as f:

    json.dump(class_names, f, ensure_ascii=False, indent=4)

print("\n===================================")
print("✅ AI Model Training Completed")
print("✅ model.keras Saved")
print("✅ labels.json Saved")
print("===================================")