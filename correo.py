from flask import Flask, request, render_template
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('formulario.html')

@app.route('/send_email', methods=['POST'])
def send_email():
    subject = request.form['subject']
    description = request.form['description']
    user_email = "user_email@example.com"  # Correo con el que el usuario esta registrado

    # Configuración del correo de la empresa
    sender_email = "tu_email@gmail.com"
    sender_password = "tu_contraseña"
    email_subject = f"Nuevo Ticket: {subject}"
    email_body = f"Descripción del Ticket:\n\n{description}"

    # Configuración del mensaje
    message = MIMEMultipart()
    message["From"] = sender_email
    message["To"] = user_email
    message["Subject"] = email_subject
    message.attach(MIMEText(email_body, "plain"))

    try:
        # Conexión al correo
        server = smtplib.SMTP("smtp.gmail.com", 587)
        server.starttls()
        server.login(sender_email, sender_password)
        server.sendmail(sender_email, user_email, message.as_string())
        server.quit()
        return "Correo enviado exitosamente"
    except Exception as e:
        return str(e)

if __name__ == '__main__':
    app.run(debug=True)