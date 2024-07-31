from flask import Flask, request, jsonify
import joblib
import pandas as pd
import traceback
import os

app = Flask(__name__)

# Load the model
model = None

try:
    model = joblib.load('./model/model.pkl')
    print("Model loaded successfully.")
except Exception as e:
    print(f"Error loading model: {e}")
    print(traceback.format_exc())

@app.route('/health', methods=['GET'])
def hello():
    return jsonify({'status': 'OK'})

@app.route('/predict', methods=['POST'])
def predict():
    global model
    if model is None:
        return jsonify({'error': 'Model is not loaded properly.'}), 500

    try:
        data = request.json

        # Ensure correct data types for numerical columns
        numerical_features = [
            "konsumsi_beras", "harga_beras", "belanja_dapur", "rekening_listrik", "pendidikan", "lainnya", "simpanan_tabungan",
            "luas_pekarangan", "total_nilai_indeks_rumah", "total_pendapatan_rumah_tangga", "jumlah_anggota_rumah_tangga",
            "pendapatan_perkapita", "tenor", "pokok", "margin", "angsuran", "umur", "total_pengeluaran", "buyer_suami", "buyer_istri"
        ]

        categorical_features = [
            "pekerjaan", "sumber_pendapatan", "status_rumah", "luas_rumah", "jenis_atap", "dinding_rumah", "jenis_penerangan",
            "jenis_jamban", "sumber_air_minum"
        ]

        features = numerical_features + categorical_features

        # Check if all features are present
        for feature in features:
            if feature not in data:
                return jsonify({'error': f'Missing feature: {feature}'}), 400

        # Convert input data to pandas DataFrame
        input_data = pd.DataFrame([data])

        for feature in numerical_features:
            input_data[feature] = pd.to_numeric(input_data[feature], errors='coerce')

        # Check for any NaN values after conversion
        if input_data[numerical_features].isnull().any().any():
            return jsonify({'error': 'One or more numerical fields contain invalid data.'}), 400

        # Convert categorical features to string if not already
        for feature in categorical_features:
            input_data[feature] = input_data[feature].astype(str).str.upper()

        # Make prediction
        prediction = model.predict(input_data)

        # Mapping prediction to label
        prediction_mapping = {
            0: "LANCAR",
            1: "1-30 HARI",
            2: "31-60 HARI",
            3: "61-90 HARI",
            4: "91-120 HARI",
            5: "LEBIH DARI 120 HARI"
        }

        result = {
            'prediction': int(prediction[0]),
            'description': prediction_mapping.get(int(prediction[0]), "Unknown Prediction")
        }
        return jsonify(result)
    except Exception as e:
        print(f"Error during prediction: {e}")
        print(traceback.format_exc())
        return jsonify({'error': str(e)}), 400

if __name__ == '__main__':
    # Baca nilai APP_DEBUG dari file .env Laravel
    debug_mode = os.getenv('APP_DEBUG', 'False').lower() in ['true', '1', 't']
    app.run(debug=debug_mode, host='0.0.0.0', port=5000)
