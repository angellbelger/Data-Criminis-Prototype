import qrcode

PG_BLUE = (27, 54, 87)
PG_GREEN = (0, 174, 150)

data = {
    '01': "https://url_aqui_link_invalido_.com"
}

if __name__ == '__main__':
    for key, value in data.items():
        img = qrcode.make(value)
        img.save(f'images/{key}.png')
