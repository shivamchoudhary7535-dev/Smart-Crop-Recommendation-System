import tensorflow as tf
from tensorflow.keras import layers, models
import json
import os

# Dataset Path
DATASET_PATH = "PlantVillage"

# Image Settings
IMG_SIZE = (224,224)
BATCH_SIZE = 32

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

print("\nTotal Classes:", len(class_names))

# Performance
AUTOTUNE = tf.data.AUTOTUNE

train_dataset = train_dataset.prefetch(AUTOTUNE)
validation_dataset = validation_dataset.prefetch(AUTOTUNE)

# Model
model = models.Sequential([
    layers.Rescaling(1./255, input_shape=(224,224,3)),

    layers.Conv2D(32,3,activation='relu'),
    layers.MaxPooling2D(),

    layers.Conv2D(64,3,activation='relu'),
    layers.MaxPooling2D(),

    layers.Conv2D(128,3,activation='relu'),
    layers.MaxPooling2D(),

    layers.Flatten(),

    layers.Dense(256,activation='relu'),

    layers.Dropout(0.3),

    layers.Dense(len(class_names),activation='softmax')
])

model.compile(
    optimizer='adam',
    loss='sparse_categorical_crossentropy',
    metrics=['accuracy']
)

print("\nTraining Started...\n")

history = model.fit(
    train_dataset,
    validation_data=validation_dataset,
    epochs=10
)

# Model Folder
os.makedirs("model", exist_ok=True)

# Save Model
model.save("model/model.keras")

# Save Labels
with open("model/labels.json","w") as f:
    json.dump(class_names,f)

print("\nModel Saved Successfully!")