import mysql.connector

def verificar_inicio_sesion(cliente_id, password):
    try:
        # Conectar a la base de datos
        conexion = mysql.connector.connect(
            host="db-2024.mysql.database.azure.com",
            user="jim",
            password="2839064Void",
            database="db-ticket"
        )

        # Crear un cursor para ejecutar consultas SQL
        cursor = conexion.cursor()

        # Consulta SQL para verificar las credenciales
        consulta = "SELECT * FROM clientes WHERE cliente_id = %s AND pass = %s"
        cursor.execute(consulta, (cliente_id, password))
        resultado = cursor.fetchone()

        # Cerrar el cursor y la conexión
        cursor.close()
        conexion.close()

        # Si se encuentra un usuario con las credenciales proporcionadas, retornar True
        if resultado:
            return True
        else:
            return False

    except mysql.connector.Error as error:
        print("Error al conectar a la base de datos:", error)
        return False

# Ejemplo de uso
cliente_id = input("Ingrese su ID de cliente: ")
password = input("Ingrese su contraseña: ")

if verificar_inicio_sesion(cliente_id, password):
    print("Inicio de sesión exitoso")
else:
    print("Inicio de sesión fallido")