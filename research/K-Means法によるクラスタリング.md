
### 画像の配色を解析する機能に使用する  
- https://qiita.com/simonritchie/items/396112fb8a10702a3644
- https://www.pyimagesearch.com/2014/05/26/opencv-python-k-means-color-clustering/

### 必要なパッケージ
- scikit-learn  
`pip3 install scikit-learn`  
- OpenCV  
`pip3 install opencv-python`  


### Deepl翻訳

---

#### OpenCVとPythonのK-Meansカラークラスタリング
`画像`  
上のジュラシック・パークの映画ポスターを見てみましょう。  
  
支配的な色は何色でしょうか？(すなわち、イメージの中で最も多く表現されている色)  
  
まあ、背景は大体黒ですね。T-レックスの周りには赤があります 実際のロゴの周りには黄色があります 
  
人間の心がこれらの色を選ぶのは非常に簡単です  
  
しかし、これらの色を自動的に抽出するアルゴリズムを作るとしたらどうでしょうか？  
  
カラーヒストグラムが一番と思うかもしれませんが...。  
  
しかし，実はもっと面白いアルゴリズムがあります．  
  
このブログ記事では，OpenCV，Python，k-means クラスタリングアルゴリズムを使って，画像の中で最も支配的な色を見つける方法を紹介します．  
  
OpenCVとPythonのバージョン。
この例はPython 2.7/Python 3.4+とOpenCV 2.4.X/OpenCV 3.0+で動作します。  
#### Ｋミーンズクラスタリング
では、k-meansとは何でしょうか？  
  
K-meansはクラスタリングアルゴリズムです。  
  
目的は、n個のデータポイントをk個のクラスタに分割することです。n個のデータポイントのそれぞれは、最も近い平均を持つクラスタに割り当てられます。各クラスタの平均は、「セントロイド」または「センター」と呼ばれます。  
  
全体的に、k-meansを適用すると、元のn個のデータポイントのk個の独立したクラスタが得られます。特定のクラスタ内のデータ点は、他のクラスタに属するデータ点よりも、互いに「より類似している」と考えられます。  
  
ここでは、RGB画像の画素強度をクラスタリングします。MxNサイズの画像が与えられると、MxN個のピクセルがあり、それぞれが3つの成分から構成されています。それぞれ赤、緑、青の3つの成分から構成されています。  
  
これらのMxNピクセルをデータポイントとして扱い、k-meansを用いてクラスタリングします。  
  
あるクラスタに属する画素は、別のクラスタに属する画素よりも色が似ています。  
  
k-meansの注意点として、事前に生成したいクラスタの数を指定する必要があります。最適なkの値を自動的に選択するアルゴリズムがありますが、この記事の範囲外です。  
  
#### OpenCVとPythonのK-Meansカラークラスタリング

それでは，OpenCV，Python，k-meansを用いて，ピクセルの強度をクラスタ化してみましょう．  

- 1~24
```python
# import the necessary packages
from sklearn.cluster import KMeans
import matplotlib.pyplot as plt
import argparse
import utils
import cv2
# construct the argument parser and parse the arguments
ap = argparse.ArgumentParser()
ap.add_argument("-i", "--image", required = True, help = "Path to the image")
ap.add_argument("-c", "--clusters", required = True, type = int,
	help = "# of clusters")
args = vars(ap.parse_args())
# load the image and convert it from BGR to RGB so that
# we can dispaly it with matplotlib
image = cv2.imread(args["image"])
image = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
# show our image
plt.figure()
plt.axis("off")
plt.imshow(image)

```

2-6行目は必要なパッケージのインポートを行います。scikit-learnで実装されているk-meansを使って生活を楽にします。また、画像と最も支配的な色を表示するためにmatplotlibを使用します。コマンドラインの引数を解析するにはargparseを使います。utilsパッケージには，後ほど説明する2つのヘルパー関数が含まれています．そして，最後に cv2 パッケージには，OpenCV ライブラリへの Python バインディングが含まれています．  
  
9-13行目は，コマンドライン引数を解析します．必要な引数は2つだけです．--image は画像がディスク上に存在する場所へのパスであり， --clusters は生成したいクラスタの数です．  
  
17-18行目では，ディスクから画像を読み込み，それをBGRからRGB色空間に変換します．OpenCVは，画像を多次元のNumPy配列として表現していることを覚えておいてください．しかし，これらの画像は，RGBではなくBGRの順番で保存されます．これを解決するには，関数 cv2.cvtColor を利用します．  
  
最後に，21-23行目のmatplotlibを用いて，画像を画面に表示します．  
  
この記事で先に述べたように，我々の目標は，n 個のデータポイントから k 個のクラスタを生成することです．MxN画像をデータポイントとして扱うことになります。  
  
これを行うためには、MxN画像をピクセルの行列ではなく、ピクセルのリストにする必要があります。  
  
- 25~26  

```python
# reshape the image to be a list of pixels
image = image.reshape((image.shape[0] * image.shape[1], 3))
```
このコードはとてもわかりやすいはずです。NumPy配列をRGBピクセルのリストに整形しているだけです。  

#### 2行のコード
データポイントの準備ができたので、画像の中で最も支配的な色を見つけるために、k-meansを使って以下の2行のコードを書くことができます。  
  
- 28~30
```python
# cluster the pixel intensities
clt = KMeans(n_clusters = args["clusters"])
clt.fit(image)
```  

我々は，アルゴリズムの再実装を避けるために，k-meansの実装であるscikit-learnを使用しています．OpenCVにもk-meansが組み込まれていますが，もしこれまでにPythonで機械学習を行ったことがあるのであれば（あるいは行うつもりがあるのであれば），scikit-learnパッケージを使うことをお勧めします．  
  
29 行目で KMeans をインスタンス化し、生成したいクラスタの数を指定します。30 行目の fit() メソッドを呼び出すと、ピクセルのリストがクラスタ化されます。  
  
Python と k-means を使った RGB ピクセルのクラスタリングは以上です。  
  
Scikit-learnはすべての機能を提供してくれます。  
  
しかし、画像の中で最も支配的な色を表示するためには、2つのヘルパー関数を定義する必要があります。  
  
utils.pyという新しいファイルを開き、centroid_histogram関数を定義してみましょう。  
  
- 1~16
```python
# import the necessary packages
import numpy as np
import cv2
def centroid_histogram(clt):
	# grab the number of different clusters and create a histogram
	# based on the number of pixels assigned to each cluster
	numLabels = np.arange(0, len(np.unique(clt.labels_)) + 1)
	(hist, _) = np.histogram(clt.labels_, bins = numLabels)
	# normalize the histogram, such that it sums to one
	hist = hist.astype("float")
	hist /= hist.sum()
	# return the histogram
	return hist
```
ご覧のように、このメソッドは単一のパラメータ clt を受け取ります。これは color_kmeans.py で作成した k-means クラスタリングオブジェクトです。  
  
k-means アルゴリズムは画像の各ピクセルを最も近いクラスタに割り当てます。8行目でクラスタの数を取得し、9行目で各クラスタに割り当てられたピクセル数のヒストグラムを作成します。  
  
最後に、このヒストグラムの和が1になるように正規化して、12-16行目で呼び出し元に返します。  
  
要するに、この関数がやっていることは、各クラスタに属するピクセルの数を数えることです。  
  
さて、2番目のヘルパー関数 plot_colors を見てみましょう。  
  
-18~34
```python
def plot_colors(hist, centroids):
	# initialize the bar chart representing the relative frequency
	# of each of the colors
	bar = np.zeros((50, 300, 3), dtype = "uint8")
	startX = 0
	# loop over the percentage of each cluster and the color of
	# each cluster
	for (percent, color) in zip(hist, centroids):
		# plot the relative percentage of each cluster
		endX = startX + (percent * 300)
		cv2.rectangle(bar, (int(startX), 0), (int(endX), 50),
			color.astype("uint8").tolist(), -1)
		startX = endX
	
	# return the bar chart
	return bar
```
plot_colors関数は2つのパラメータを必要とします： histはcentroid_histogram関数で生成されたヒストグラム、centroidsはk-meansアルゴリズムで生成されたセントロイド（クラスタの中心）のリストです。  
  
21行目では、画像の中で最も支配的な色を保持するために300×50ピクセルの矩形を定義しています。  
  
26行目で色とパーセンテージのループ処理を開始し、29行目で現在の色が画像に占めるパーセンテージを描画します。そして、34 行目に色のパーセンテージバーを呼び出し元に返します。  
  
繰り返しになりますが、この関数は非常にシンプルなタスクを実行しています - centroid_histogram関数の出力に基づいて、各クラスタに割り当てられたピクセル数を表示する図を生成します。  
  
2つのヘルパー関数が定義されたので、すべてを結合することができます。  
  
- 32~41
```python
# build a histogram of clusters and then create a figure
# representing the number of pixels labeled to each color
hist = utils.centroid_histogram(clt)
bar = utils.plot_colors(hist, clt.cluster_centers_)
# show our color bart
plt.figure()
plt.axis("off")
plt.imshow(bar)
plt.show()
```
34行目で、各クラスタに割り当てられたピクセル数をカウントします。そして35行目で、各クラスタに割り当てられたピクセル数を可視化する図を生成します。  
  
38～41行目で図が表示されます。  
  
スクリプトを実行するには、以下のコマンドを実行してください。  
```s
$ python color_kmeans.py --image images/jp.png --clusters 3
```
順調にいけば、下のようなものが出てくるはずです。  
`画像`  
ここでは、私たちのスクリプトが3つのクラスタを生成したことがわかります（コマンドライン引数で3つのクラスタを指定したので）。最も支配的なクラスターは黒、黄色、赤で、これらはすべてジュラシック・パークの映画のポスターで大きく表現されています。  
  
これをThe Matrixのスクリーンショットに適用してみましょう。
  
`画像`  
今回はk-meansに4つのクラスタを生成するように指示しました。ご覧のように、黒と緑の濃淡が最も支配的な色であることがわかります。  
  
最後に、このバットマンの画像に対して5色のクラスタを生成してみましょう。  
  
`画像`  
これがそうです．  
  
OpenCV, Python, k-meansを使ってRGBピクセルの強度をクラスタリングして、画像の中で最も支配的な色を見つけるのはとても簡単です。Scikit-learnがすべての作業を代行してくれます。この記事のコードのほとんどは、すべてのパーツを接着するために使われています。  
  
#### 概要
今回のブログ記事では、OpenCV、Python、k-meansを使って画像の中で最も支配的な色を見つける方法を紹介しました。

k-meansは、n個のデータポイントに基づいてk個のクラスタを生成するクラスタリングアルゴリズムです。クラスター数kはあらかじめ指定しておく必要があります。kの最適値を求めるアルゴリズムは存在しますが、このブログ記事の範囲外です。

画像の中で最も支配的な色を見つけるために、ピクセルをデータポイントとして扱い、それらをクラスタ化するためにk-meansを適用しました。  
  
k-meansの再実装を避けるために、scikit-learnの実装を使用しました。  
  
ぜひ、自分の画像にk-meansクラスタリングを適用してみてください。一般的には、クラスタ数が少ない（k <=5）方が最良の結果が得られることがわかるでしょう。  


www.DeepL.com/Translator（無料版）で翻訳しました。