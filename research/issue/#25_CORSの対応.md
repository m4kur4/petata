### S3�o�P�b�g�ɋ��ݒ������
https://docs.aws.amazon.com/ja_jp/AmazonS3/latest/dev/cors.html#how-do-i-enable-cors
- �A�N�Z�X����>CORS�̐ݒ�
  - CORS�\���G�f�B�^�[
  - HEAD�͕K�{(�A�N�Z�X���\���ǂ����̑O�����Ŏg���炵��)  
  https://stackoverflow.com/questions/17533888/s3-access-control-allow-origin-header
  ```
    <CORSConfiguration>
    <CORSRule>
    <AllowedOrigin>https://petata.jp</AllowedOrigin>

    <AllowedMethod>HEAD</AllowedMethod>
    <AllowedMethod>GET</AllowedMethod>

    <AllowedHeader>*</AllowedHeader>
    </CORSRule>
    </CORSConfiguration>
  ```
  - �������|���V�[�X�V�O����A�b�v���[�h���Ă��郊�\�[�X�ɂ͔��f����Ȃ����ߒ���
### �����̏C��
https://qiita.com/att55/items/2154a8aad8bf1409db2b
- `fetch()`�̃I�v�V������ݒ肷��B
```js
            const img = await fetch(image.src, {
                mode: 'cors',
            });
```
### CORS�ɂ���
https://qiita.com/att55/items/2154a8aad8bf1409db2b
- �I���W���ԃ��\�[�X���L
- �I���W�� = �h���C�� + �|�[�g�ԍ�
  - ����h���C���ł��|�[�g�ԍ����Ƃɋ�ʂ���Ƃ�������
  - �Z�L�����e�B�|���V�[(�z���C�g���X�g)�Ƃ��ė��p����T�O
- ���\�[�X = Web�R���e���c�ɑ΂���A�N�Z�X���I���W���P�ʂŃA�N�Z�X���䂷�邱�Ƃɂ��A  
�Ӑ}���Ȃ��R���e���c�̔z�M��Ǝ㐫��˂����U����h�~����B  
