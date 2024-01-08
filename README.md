# PokeShop

import os
import subprocess
import json

def convert_docx_to_text(docx_path, text_path):
    subprocess.call(['pandoc', docx_path, '-t', 'plain', '-o', text_path])

def format_text_file(input_path, output_path):
    with open(input_path, 'r') as file:
        text_content = file.read()
    text_content = text_content.replace('\\', '\\\\').replace('"', '\\"').replace('\n', '\\n')
    with open(output_path, 'w') as file:
        file.write(text_content)

def create_json_file(text_file, json_file, original_name):
    with open(text_file, 'r') as file:
        text_content = file.read()
    data = {"name": original_name, "data": text_content}
    with open(json_file, 'w') as file:
        json.dump(data, file)

directory = 'docx'

for filename in os.listdir(directory):
    if filename.endswith('.docx'):
        docx_path = os.path.join(directory, filename)
        base_name = os.path.splitext(filename)[0]
        text_path = os.path.join(directory, base_name + '.txt')
        formatted_text_path = os.path.join(directory, base_name + '_formatted.txt')
        json_path = os.path.join(directory, base_name + '.json')

        convert_docx_to_text(docx_path, text_path)
        format_text_file(text_path, formatted_text_path)
        create_json_file(formatted_text_path, json_path, filename)
