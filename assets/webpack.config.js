const path = require('path')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const miniCss = require('mini-css-extract-plugin');

module.exports = {
    entry: {
        main: path.resolve(__dirname, './src/app.js'),
    },
    output: {
        path: path.resolve(__dirname, './dist'),
        filename: '[name].bundle.js',
    },

    module: {
        rules: [
            // js
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ['babel-loader'],
            },
            {
                test:/\.(s*)css$/,
                use: [
                    miniCss.loader,
                    'css-loader',
                    'postcss-loader',
                    'sass-loader',
                ]
            }
        ],
    },

    plugins: [
        new CleanWebpackPlugin(),
        new miniCss({
            filename: 'style.css',
        }),
    ],
}