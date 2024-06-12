from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
import urllib

app = Flask(__name__)

# Configuración de la cadena de conexión a Azure SQL Database
params = urllib.parse.quote_plus("DRIVER={ODBC Driver 17 for SQL Server};"
                                 "SERVER=db-2024.mysql.database.azure.com;"
                                 "DATABASE=db-ticket;"
                                 "UID=jim;"
                                 "PWD=2839064Void;"
                                 "Encrypt=yes;"
                                 "TrustServerCertificate=no;"
                                 "Connection Timeout=30;")

app.config['SQLALCHEMY_DATABASE_URI'] = f'mssql+pyodbc:///?odbc_connect={params}'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

# Definición del modelo de Ticket
class Cliente(db.Model):
    __tablename__ = 'clientes'
    cliente_id = db.Column(db.String, primary_key=True)
    pass = db.Column(db.String)

    def to_dict(self):
        return {
            'cliente_id': self.cliente_id,
            'pass': self.pass
        }

@app.route('/login', methods=['POST'])
def login():
    if request.method == 'POST':
        data = request.json
        username = data.get('username')
        password = data.get('password')
        
        # Consulta SQL para verificar el usuario y la contraseña
        cliente = Cliente.query.filter_by(cliente_id=username, pass=password).first()
        
        if cliente:
            # Si hay al menos un resultado, el usuario y la contraseña son correctos
            return jsonify({"message": "Login successful", "redirect": "home.html"}), 200
        else:
            # Si no hay resultados, el usuario y/o la contraseña son incorrectos
            return jsonify({"message": "Usuario y/o contraseña incorrectos"}), 401
    else:
        return jsonify({"message": "Acceso denegado"}), 403

if __name__ == '__main__':
    app.run(debug=True)