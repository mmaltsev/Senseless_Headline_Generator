# -*- coding: cp1251 -*-
import random
import urllib
import simplejson
import pymorphy2

file_ = open('D://pytest.txt')

class Markov(object):
        
        def __init__(self, open_file):
                self.cache = {}
                self.first_word = []
                self.second_word = {}
                self.open_file = open_file
                self.lines = self.file_to_lines()
                self.words = []
                self.lines_size = len(self.lines)
                self.database()
                self.bid_list = ['в', 'от', 'для', 'об', 'с', 'со', 'до', 'за', 'и', 'а', 'к', 'о', 'на', 'по', 'не']
                
        
        def file_to_lines(self):
                self.open_file.seek(0)
                data = self.open_file.read()
                lines = data.split('\n')
                return lines
                
        
        def triples(self):
                """ Generates triples from the given data string. So if our string were
                                "What a lovely day", we'd generate (What, a, lovely) and then
                                (a, lovely, day).
                """
                for j in range(len(self.lines)):
                    self.words = self.lines[j].split()
                    if len(self.words) > 2:
                        for i in xrange(len(self.words) - 2):
                            yield (self.words[i], self.words[i+1], self.words[i+2])
                        
                        
        def database(self):
                self.open_file.seek(0)
                for line in file_:
                    f_tmp = line.split()[0]
                    s_tmp = line.split()[1]
                    self.first_word.append(f_tmp)
                    if f_tmp in self.second_word:
                        self.second_word[f_tmp].append(s_tmp)
                    else:
                        self.second_word[f_tmp] = [s_tmp]
                for w1, w2, w3 in self.triples():
                        key = (w1.lower(), w2.lower())
                        if key in self.cache:
                                self.cache[key].append(w3)
                        else:
                                self.cache[key] = [w3]

        
        def generate_markov_text(self, size=7):
            test_var = 0
            while test_var != 1:
                test_var = 1
                seed = random.randint(0, len(self.first_word)-1)
                w1, w2 = self.first_word[seed], random.choice(self.second_word[self.first_word[seed]])
                #seed = random.randint(0, self.lines_size-1)
                #split_line = self.lines[seed].split()
                #seed = random.randint(0, len(split_line)-2)
                #w1, w2 = split_line[seed].upper(), split_line[seed+1]
                #w1, w2 = "Жириновский", random.choice(self.second_word["Жириновский"])
                gen_words = []
                flag = 0
                for i in xrange(size):
                        gen_words.append(w1)
                        if (w1.lower(),w2.lower()) in self.cache:
                            w1, w2 = w2, random.choice(self.cache[(w1.lower(), w2.lower())])
                        else:
                            flag = 1
                            break
                if flag == 1 and w2 not in self.bid_list and ',' not in w2 and ':' not in w2 and ';' not in w2 and '.' not in w2:
                    gen_words.append(w2)
                elif flag == 0 and w1 not in self.bid_list and ',' not in w1 and ':' not in w1 and ';' not in w1 and '.' not in w1:
                    gen_words.append(w1)
                poten_hdl = ' '.join(gen_words)
                for j in xrange(len(self.lines)):
                    if poten_hdl in self.lines[j]:
                        test_var = 0
                        break
            return poten_hdl
for i in xrange(20):
    markov = Markov(file_)
    headline = markov.generate_markov_text()
    if headline.count('«') > headline.count('»'):
        headline += '»'*(headline.count('«') - headline.count('»'))
    elif headline.count('«') < headline.count('»'):
        headline = '«'*(headline.count('»') - headline.count('«')) + headline
    if headline.count('"') % 2 > 0:
        headline += headline + '"'
    print(headline)
    p = input('input ')
    if p == 1:
        def search(text):
            query = urllib.urlencode({'q' : text.encode("utf-8")})
            url = u'http://ajax.googleapis.com/ajax/services/search/news?v=1.0&%s'.encode("utf-8") \
            % (query)+u'&hl=ru&ned=ru&userip=46.39.46.42'
            search_results = urllib.urlopen(url)
            json = simplejson.loads(search_results.read())
            cursor = json['responseData']['cursor']
            results = json['responseData']['results']
            return results, cursor
        
        fout1 = open('results/news_total.txt','a+')
        #fout1 = open('results/web.txt','a+')
        fout2 = open('results/news_scope.txt','a+')
        #sign = ['!', '?']
        fout1.write(headline)
        fout2.write( headline)
        headline = unicode(headline, 'cp1251')
        split_hdl = headline.split()
        n = len(split_hdl)
        X = [[0 for x in xrange(n-2)] for x in xrange(n-2)]
        index_row = 0
        index_col = 0
        for i in xrange(n-2):
            fout1.write('\n')
            fout1.write(`i+3` + "grams: ")
            for j in xrange(n-i-2):
                gram = ''
                for k in xrange(j,i+j+3):
                    gram += split_hdl[k] + ' '
                results, cursor = search('"' + gram + '"')
                if results:
                    fout1.write('0 ')
                    X[index_col][index_row] = 0
                    index_row += 1
                else:
                    fout1.write('1 ')
                    X[index_col][index_row] = 1
                    index_row += 1
            index_row = 0
            index_col += 1
        
        k_sum = 0.0
        senseless_level = 0.0
        m_sum = 0.0
        for k in xrange(n-2):
            x_sum = 0.0
            for j in xrange(n-k-2):
                x_sum += X[k][j]
            k_sum = k_sum + float(k+1)*float(x_sum)/float(n-k-2)
            m_sum += k+1
        senseless_level =  1.0/float(m_sum)*float(k_sum)*100.0
        fout1.write('\n' + `int(round(senseless_level))` + "%\n\n")
        fout2.write('\n' + `int(round(senseless_level))` + "%\n\n")
        fout1.close()
        fout2.close()