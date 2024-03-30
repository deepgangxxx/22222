import re
import requests
import asyncio
from telethon import TelegramClient, events


API_ID = 18529274
API_HASH = '836ba21afb518f26432b8d37e3acdcc6'
SEND_CHAT = '1001998157925'
chats = ['@SpectrionChat', '@OficialScorpionsGrupo',
'@kurumichks',
"@SakuraChkChat",
"@LigthStormChat",
        '@ChatA2Assiad',
'@kurumichks',
    '@techzillacheckerchat',
    '@oficialscorpionsgrupo',
     '@Venexchk',
     '@ChatKurama',
     '@savagegroupoficial',
     '@albaytuhaker']
PALABRAS_CLAVE = ['𝑨𝑷𝑷𝑹𝑶𝑽𝑬𝑫 𝑪𝑪𝑵 ✅','𝑨𝒑𝒑𝒓𝒐𝒗𝒆𝒅', '𝐀𝐩𝐩𝐫𝐨𝐯𝐞𝐝 ✅', 'approved','APPROVED','charged','CHARGED','CVV','CCN','Card Details','• Card']

client = TelegramClient('session', API_ID, API_HASH)
# Remover las líneas que crean el botón en la función create_message()
async def create_message(cc):
    extra = cc["number"][0:12]
    bin2 = cc["number"][0:6]
    try:
        bin_json = (requests.get(f'https://bins.antipublic.cc/bins/{cc}')).json()
        #datab = bin_json['data']
        bin2 = bin_json["bin"]
        brand = bin_json["brand"]
        typeq = bin_json["typeq"]
        #vendor = bin_json['vendor']
        level = bin_json["level"]
        bank = bin_json["bank"]
        country = bin_json["country_flag"]
        emoji = bin_json["country_name"]
        code = bin_json["country"]
        info = f'{brand} - {typeq} - {level}' if typeq and level else brand

        message = f"""
       『 ⚡️ 𝗨𝗹𝘁𝗿𝗮 𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿 ⚡️ 』
▰━▱━▰━▱━▰━▣━▰━▱━▰━▱━▰
💳 𝘾𝘾 𝘼𝙥𝙥𝙧𝙤𝙫𝙚𝙙 ➜ `{cc["number"]}|{cc["month"]}|{cc["year"]}|{cc["cvv"]}`
  𝘾𝘾 𝙀𝙭𝙩𝙧𝙖 ➜ `{extra}xxxx|{cc["month"]}|{cc["year"]}|rnd`
▰━▱━▰━▱━▰━▣━▰━▱━▰━▱━▰
🛸 𝘽𝙞𝙣 ➜ ´{bin2}´
🌐𝘾𝙤𝙪𝙣𝙩𝙧𝙮 ➜ ´{country} - {emoji} - {code}´
🪨 𝙄𝙣𝙛𝙤  ➜ ´{info}´
🏛 𝘽𝙖𝙣𝙠 ➜ ´{bank} - {emoji}´
▰━▱━▰━▱━▰━▣━▰━▱━▰━▱━▰
"""
        return message
    except:  # noqa: E722
        return None


async def send_ccs(ccs):
    sent_ccs = set()
    tasks = []
    for cc in ccs:
        if cc["number"] not in sent_ccs:
            message = await create_message(cc)
            if message is None:
                continue
            tasks.append(client.send_file(SEND_CHAT, file='asuna.jpg', caption=message))  # noqa: E999, E501
            sent_ccs.add(cc["number"])
            await asyncio.sleep(1)
    sent_messages = await asyncio.gather(*tasks)
    return sent_messages






cc_regex = r'(\d{4}\s?\d{4}\s?\d{4}\s?\d{2,4})\D+(\d{1,2})\D+(\d{2,4})\D+(\d{3})'


@client.on(events.NewMessage(chats=chats))
async def new_order(event,):
    try:
        palabra_clave = await asyncio.gather(*[match_key(event.message.message, key) for key in PALABRAS_CLAVE])  # noqa: E501
        if any(palabra_clave):
            cc_matches = re.findall(cc_regex, event.message.message)
            if cc_matches:
                ccs = []
                for cc_match in cc_matches:
                    cc = {
                        'number': cc_match[0].replace(' ', ''),
                        'month': cc_match[1],
                        'year': cc_match[2],
                        'cvv': cc_match[3]
                    }
                    if cc not in send_ccs:
                        ccs.append(cc)
                        send_ccs.append(cc)
                if len(ccs) > 0:
                    print(f'Se encontraron {len(ccs)} CCs en el mensaje: {event.message.message}')    # noqa: E501
                    await send_ccs(ccs)
    except Exception as e:
        print(f'Ocurrió un error al procesar el mensaje: {str(e)}')

async def match_key(message, key):
    return key in message



client.start()
client.run_until_disconnected()