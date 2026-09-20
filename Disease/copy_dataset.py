import os
import shutil

SOURCE = "PlantVillage"
DEST = "Dataset_AI"

mapping = {

    # Tomato
    "Tomato_healthy": ("Tomato", "Healthy"),
    "Tomato_Early_blight": ("Tomato", "Early_Blight"),
    "Tomato_Late_blight": ("Tomato", "Late_Blight"),
    "Tomato_Bacterial_spot": ("Tomato", "Bacterial_Spot"),
    "Tomato_Leaf_Mold": ("Tomato", "Leaf_Mold"),
    "Tomato_Septoria_leaf_spot": ("Tomato", "Septoria_Leaf_Spot"),
    "Tomato_Spider_mites_Two_spotted_spider_mite": ("Tomato", "Spider_Mites"),
    "Tomato__Target_Spot": ("Tomato", "Target_Spot"),
    "Tomato__Tomato_mosaic_virus": ("Tomato", "Mosaic_Virus"),
    "Tomato__Tomato_YellowLeaf__Curl_Virus": ("Tomato", "Yellow_Leaf_Curl"),

    # Potato
    "Potato___healthy": ("Potato", "Healthy"),
    "Potato___Early_blight": ("Potato", "Early_Blight"),
    "Potato___Late_blight": ("Potato", "Late_Blight"),

    # Pepper
    "Pepper__bell___healthy": ("Capsicum", "Healthy"),
    "Pepper__bell___Bacterial_spot": ("Capsicum", "Bacterial_Spot"),
}

for src_folder, (crop, disease) in mapping.items():

    src = os.path.join(SOURCE, src_folder)

    dst = os.path.join(DEST, crop, disease)

    if not os.path.exists(src):
        print("Not Found:", src)
        continue

    os.makedirs(dst, exist_ok=True)

    copied = 0

    for file in os.listdir(src):

        if file.lower().endswith((".jpg",".jpeg",".png")):

            shutil.copy2(
                os.path.join(src,file),
                os.path.join(dst,file)
            )

            copied += 1

    print(f"{src_folder} -> {crop}/{disease} : {copied} images copied")

print("\nDONE")