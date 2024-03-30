# Importar bibliotecas necesarias
import os
import telebot

# Obtener token del bot desde las variables de entorno
BOT_TOKEN = os.environ.get('7084078830:AAHmg_dLKFRM8T-DtNQMRKqJ0yA34jd9S0E')

# Crear objeto de bot
bot = telebot.TeleBot(BOT_TOKEN)

# Manejador del comando /start
@bot.message_handler(commands=['start'])
def send_welcome(message):
   
  # Inline Button
  markup = telebot.types.InlineKeyboardMarkup()
  markup.add(telebot.types.InlineKeyboardButton("developer", url="T.me/al3xcodex"))

  markdown = f"""Hola @{message.chat.username},¡Bienvenido S𝚌𝚛𝚊𝚙𝚙 𝙲𝙴𝙳𝚎𝚡 !\n\n
¡Gracias por utilizar este bot!\n\n
You Can Use /cmds"""
  
  bot.reply_to(message, markdown, parse_mode="Markdown", reply_markup=markup)
  print(f"Welcome Message Sent To {message.chat.first_name}\n")


# Manejador del comando /cmds
@bot.message_handler(commands=['cmds'])
def send_commands(message):
    # Crear botones inline
    button1 = telebot.types.InlineKeyboardButton("Extrapolación", callback_data="Extrapolación")
    button2 = telebot.types.InlineKeyboardButton("Extra Search", callback_data="ExtraSearch")

    # Crear markup para el teclado inline
    markup = telebot.types.InlineKeyboardMarkup()

    # Agregar botones inline al markup
    markup.add(button1, button2)
  
    # Enviar mensaje con la lista de comandos y el teclado inline
    bot.reply_to(message, "S𝚌𝚛𝚊𝚙𝚙 C𝚢𝚌𝚕𝚘𝚗𝚎", reply_markup=markup)

# Manejador de eventos de callback_query
@bot.callback_query_handler(func=lambda call: True)
def callback_handler(call):
    # Obtener identificador del chat y el mensaje original
    chat_id = call.message.chat.id
    message_id = call.message.message_id

    # Manejar eventos de cada botón
    if call.data == "Extrapolación":
        bot.answer_callback_query(call.id, "Eres hetero")
    elif call.data == "ExtraSearch":
        bot.answer_callback_query(call.id, "Eres gay ")

# Iniciar bot y esperar nuevos mensajes
bot.polling()
