import os
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "2"

import tensorflow as tf
from tensorflow.keras import layers, models
from tensorflow.keras.applications import MobileNetV2
from tensorflow.keras.callbacks import (
    ModelCheckpoint,
    EarlyStopping,
    ReduceLROnPlateau
)
import json

# ===========================
# Dataset Path
# ===========================

TRAIN_PATH = "Dataset_AI/Rice/train"
VALID_PATH = "Dataset_AI/Rice/valid"

IMG_SIZE = (224,224)
BATCH_SIZE = 16
EPOCHS = 20

# ===========================
# Load Dataset
# ===========================

train_dataset = tf.keras.preprocessing.image_dataset_from_directory(
    TRAIN_PATH,
    image_size=IMG_SIZE,
    batch_size=BATCH_SIZE,
    shuffle=True
)

val_dataset = tf.keras.preprocessing.image_dataset_from_directory(
    VALID_PATH,
    image_size=IMG_SIZE,
    batch_size=BATCH_SIZE,
    shuffle=False
)

class_names = train_dataset.class_names

print("\nDetected Classes:")
print(class_names)

AUTOTUNE = tf.data.AUTOTUNE

train_dataset = train_dataset.prefetch(AUTOTUNE)
val_dataset = val_dataset.prefetch(AUTOTUNE)

# ===========================
# Data Augmentation
# ===========================

data_augmentation = models.Sequential([
    layers.RandomFlip("horizontal"),
    layers.RandomRotation(0.15),
    layers.RandomZoom(0.15),
    layers.RandomContrast(0.10),
])

# ===========================
# Base Model
# ===========================

base_model = MobileNetV2(
    input_shape=(224,224,3),
    include_top=False,
    weights="imagenet"
)

base_model.trainable = False

# ===========================
# Build Model
# ===========================

inputs = layers.Input(shape=(224,224,3))

x = data_augmentation(inputs)

x = tf.keras.applications.mobilenet_v2.preprocess_input(x)

x = base_model(x, training=False)

x = layers.GlobalAveragePooling2D()(x)

x = layers.Dropout(0.3)(x)

x = layers.Dense(256, activation="relu")(x)

x = layers.Dropout(0.2)(x)

outputs = layers.Dense(
    len(class_names),
    activation="softmax"
)(x)

model = models.Model(inputs,outputs)

model.compile(
    optimizer=tf.keras.optimizers.Adam(1e-4),
    loss="sparse_categorical_crossentropy",
    metrics=["accuracy"]
)

model.summary()

# ===========================
# Callbacks
# ===========================

os.makedirs("model_rice",exist_ok=True)

callbacks=[

    ModelCheckpoint(
        "model_rice/model.keras",
        monitor="val_accuracy",
        save_best_only=True,
        verbose=1
    ),

    EarlyStopping(
        monitor="val_accuracy",
        patience=5,
        restore_best_weights=True,
        verbose=1
    ),

    ReduceLROnPlateau(
        monitor="val_loss",
        factor=0.3,
        patience=2,
        verbose=1
    )

]
# ===========================
# Train Model
# ===========================

history = model.fit(
    train_dataset,
    validation_data=val_dataset,
    epochs=EPOCHS,
    callbacks=callbacks
)

# ===========================
# Fine Tune MobileNetV2
# ===========================

print("\n==============================")
print("Fine Tuning Started...")
print("==============================")

base_model.trainable = True

# Sirf last 20 layers train hongi
for layer in base_model.layers[:-20]:
    layer.trainable = False

model.compile(
    optimizer=tf.keras.optimizers.Adam(5e-6),
    loss="sparse_categorical_crossentropy",
    metrics=["accuracy"]
)

history_finetune = model.fit(
    train_dataset,
    validation_data=val_dataset,
    epochs=15,
    callbacks=callbacks
)

# ===========================
# Save Labels
# ===========================

with open("model_rice/labels.json", "w") as f:
    json.dump(class_names, f, indent=4)

# ===========================
# Evaluate Test Dataset
# ===========================

TEST_PATH = "Dataset_AI/Rice/test"

if os.path.exists(TEST_PATH):

    test_dataset = tf.keras.preprocessing.image_dataset_from_directory(
        TEST_PATH,
        image_size=IMG_SIZE,
        batch_size=BATCH_SIZE,
        shuffle=False
    )

    test_dataset = test_dataset.map(
        lambda x, y: (
            tf.keras.applications.mobilenet_v2.preprocess_input(
                tf.cast(x, tf.float32)
            ),
            y
        )
    )

    test_dataset = test_dataset.prefetch(tf.data.AUTOTUNE)

    loss, acc = model.evaluate(test_dataset)

    print("\n==============================")
    print("Test Accuracy :", round(acc * 100, 2), "%")
    print("==============================")

# ===========================
# Finished
# ===========================

print("\n===================================")
print("Rice Model Training Completed")
print("===================================")

print("Model Saved : model_rice/model.keras")
print("Labels Saved: model_rice/labels.json")

print("\nClasses :")

for i, cls in enumerate(class_names):
    print(i, "->", cls)