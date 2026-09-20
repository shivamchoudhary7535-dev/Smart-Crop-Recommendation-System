import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras import layers, models
import json
import os

# Dataset Path
DATASET = "Dataset_AI/Wheat"

IMG_SIZE = (160,160)

BATCH = 16

train = ImageDataGenerator(
    rescale=1./255,
    validation_split=0.2
)

train_data = train.flow_from_directory(
    DATASET,
    target_size=IMG_SIZE,
    batch_size=BATCH,
    subset="training",
    class_mode="categorical"
)

val_data = train.flow_from_directory(
    DATASET,
    target_size=IMG_SIZE,
    batch_size=BATCH,
    subset="validation",
    class_mode="categorical"
)

model = models.Sequential([

    layers.Conv2D(32,(3,3),activation="relu",input_shape=(160,160,3)),
    layers.MaxPooling2D(),

    layers.Conv2D(64,(3,3),activation="relu"),
    layers.MaxPooling2D(),

    layers.Conv2D(128,(3,3),activation="relu"),
    layers.MaxPooling2D(),

    layers.Flatten(),

    layers.Dense(128,activation="relu"),

    layers.Dropout(0.3),

    layers.Dense(train_data.num_classes,activation="softmax")

])

model.compile(

    optimizer="adam",

    loss="categorical_crossentropy",

    metrics=["accuracy"]

)

model.fit(

    train_data,

    validation_data=val_data,

    epochs=15

)

os.makedirs("model_wheat",exist_ok=True)

model.save("model_wheat/model.keras")

labels=list(train_data.class_indices.keys())

with open("model_wheat/labels.json","w") as f:

    json.dump(labels,f)

print("Training Complete")