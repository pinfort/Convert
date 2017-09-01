## Number Converter v0.0.1

Please show HowToUse.php to know usage.

### Dependencies

This Library depends GMP library.

### About

このライブラリは PHP で数値の変換を行うためのライブラリです。
詳細な利用方法は HowToUse.php を参照してください。

### 利用可能な関数

このライブラリでは以下の相互変換が利用可能です

- 二進 (Binarystring)
- 十進 (Decimal)
- 十六進 (Hexadecimal)
- Base64

十進の入力値に対しては非常に大きな数の文字列としての入力に対しても対応しています。
もちろんintとしての入力にも対応しています。

また、このライブラリはすべての数値をバイナリ文字列として保持します。
その時何ビットで0埋めするかをコンストラクタで指定できます。

未入力の場合、もしくは実際の入力値のビット数が指定より大きい場合は0埋めを行いません。

Base64変換を行う場合、この0埋めビット数を6の倍数ビットにしなければ数値が変わってしまいますので注意してください。

