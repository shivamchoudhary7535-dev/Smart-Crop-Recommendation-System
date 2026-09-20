import os
import cv2
import numpy as np
import tensorflow as tf

model = tf.keras.models.load_model("model_maize/best_model.keras")

classes = [
    "Gray_Leaf_Spot",
    "Healthy",
    "Leaf_Blight",
    "Rust"
]

folder = "Dataset_AI/Maize/Rust"

count = 0

for file in os.listdir(folder):

    if not file.lower().endswith((".jpg",".jpeg",".png",".jfif")):
        continue

    img = cv2.imread(os.path.join(folder,file))

    img = cv2.resize(img,(224,224))
    img = img.astype("float32")/255.0
    img = np.expand_dims(img,0)

    pred = model.predict(img,verbose=0)[0]

    print("\n",file)
    print("Gray_Leaf_Spot :", pred[0])
    print("Healthy        :", pred[1])
    print("Leaf_Blight    :", pred[2])
    print("Rust           :", pred[3])
    print("Prediction --->",classes[np.argmax(pred)])

    count += 1

    if count == 5:
        break