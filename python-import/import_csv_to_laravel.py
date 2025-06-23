import mysql.connector
import pandas as pd
from datetime import datetime

def connect():
    return mysql.connector.connect(
        host="127.0.0.1",
        port=3306,
        user="root",
        password="",
        database="ntt21"
    )

def import_csv_to_db(file_path):
    try:
        df = pd.read_csv(file_path)

        # Kolom yang harus ada di CSV
        required_columns = {
            'name', 'address', 'description', 'facilities',
            'location', 'single_room_price', 'double_room_price', 'family_room_price'
        }

        if not required_columns.issubset(df.columns):
            raise Exception(f"❌ CSV missing columns: {required_columns - set(df.columns)}")

        # Ubah NaN jadi None (untuk NULL di MySQL)
        df = df.where(pd.notnull(df), None)

        conn = connect()
        cursor = conn.cursor()

        sql = """
        INSERT INTO hotels 
        (name, address, description, image, facilities, location,
         single_room_price, double_room_price, family_room_price,
         created_at, updated_at)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """

        now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

        for _, row in df.iterrows():
            data = (
                row['name'],
                row['address'],
                row['description'],
                None,  # image kosong/null
                row['facilities'],
                row['location'],
                float(row['single_room_price']) if row['single_room_price'] is not None else None,
                float(row['double_room_price']) if row['double_room_price'] is not None else None,
                float(row['family_room_price']) if row['family_room_price'] is not None else None,
                now,
                now
            )
            cursor.execute(sql, data)

        conn.commit()
        print(f"✅ Successfully imported {len(df)} hotels from '{file_path}'!")

    except Exception as e:
        print(f"❌ Error: {e}")

    finally:
        if 'cursor' in locals(): cursor.close()
        if 'conn' in locals(): conn.close()

if __name__ == "__main__":
    import_csv_to_db("hotel.csv")
