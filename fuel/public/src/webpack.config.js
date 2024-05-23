const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');


module.exports = {
    entry: "./src/index.js",

    module: {
        rules: [
            {
                test: /\.(js|jsx)$/, // .js と .jsx ファイルを対象に
                exclude: /node_modules/, // node_modules は除外
                use: {
                    loader: 'babel-loader' // Babelローダーを使用
                }
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader'],
            },
            {
                test: /\.(png|jpe?g|gif|svg)$/i, // 画像ファイルを対象に
                use: [
                    {
                        loader: 'file-loader', // file-loader を使用
                        options: {
                            name: '[name].[ext]',
                            outputPath: 'images/', // 出力ディレクトリ
                        }
                    }
                ]
            }
        ]
    },
    resolve: {
        extensions: ['.js', '.jsx']
    },

    output: {
        path: path.resolve(__dirname, '../assets/js/'),
        filename: "main.bundle.js"
    },
    mode: 'production',
};