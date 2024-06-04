<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Documentatie - AcVis</title>
    <link rel="stylesheet" href="assets/css/docum.css">
</head>

<body>
    <article resource="#" typeof="schema:ScholarlyArticle">
        <header>
          <h2 property="schema:name">Actors Smart Visualiser</h2>
          <!-- <p role="doc-subtitle" property="schema:alternateName">
            The Future of the Scientific Method.
          </p> -->
        </header>
        <meta property="schema:accessibilityFeature" content="alternativeText">
        <meta property="schema:accessibilityFeature" content="MathML">
        <meta property="schema:accessibilityHazard" content="noFlashingHazard">
      </article>

      <div role="contentinfo">
        <ul>
          <li><a href="#revizuiri">Revizuiri</a></li>
            <li><a href="#introduction"> Introducere</a>
            <ul>
              <li><a href="#scop1"><span>1.1 </span>Scop </a></li>
              <li><a href="#conventii1"><span>1.2 </span>Convențiile documentului</a></li>
              <li><a href="#publicul1"><span>1.3 </span>Publicul vizat</a>
              <li><a href="#domeniul1"><span>1.4 </span>Domeniul de aplicare al produsului</a>
              <li><a href="#referinte1"><span>1.5 </span>Referințe</a></li>
		  </ul>
          </li>
          <li><a href="#ovarall-description">Descrierea generala a aplicației</a>
            <ul>
              <li><a href="#perspectiva2"><span>2.1 </span>Perspectiva produsului</a></li>
              <li><a href="#functii2"><span>2.2 </span>Funcțiile produsului</a></li>
              <li><a href="#caracteristici2"><span>2.3 </span>Clasele si caracteristicile utilizatorului</a></li>
              <li><a href="#mediu-operare2"><span>2.4 </span>Mediul de operare</a></li>
              <li><a href="#constrangeri2"><span>2.5 </span>Constrângeri de proiectare și implementare</a></li>
              <li><a href="#documentatie2"><span>2.6 </span>Documentația utilizatorului</a></li>
              <li><a href="#ipoteze2"><span>2.7 </span>Ipoteze și dependențe</a></li>
            </ul>
          </li>
          <li><a href="#external-interface-requirments">Cerințe de interfață externă</a>
            <ul>
              <li><a href="#interfata-utilizator3"><span>3.1 </span>Interfața cu utilizatorul</a></li>
              <li><a href="#interfata-hardwere3"><span>3.2 </span>Interfețe hardwere</a></li>
              <li><a href="#interfata-softwere3"><span>3.3 </span>Interfețe softwere</a></li>
              <li><a href="#interfata-comunicare3"><span>3.4 </span>Interfețe de comunicare</a></li>
            </ul>
          </li>
          <li><a href="#system-features">Caracteristicile sistemului</a></li>
          <li><a href="#other-nonfunctional-requirments">Alte cerințe</a>
            <ul>
              <li><a href="#performanta5"><span>5.1 </span>Cerințe de performanță</a></li>
              <li><a href="#siguranta5"><span>5.2 </span>Cerințe de siguranță în cadrul aplicației</a></li>
              <li><a href="#securitate5"><span>5.3 </span>Cerințe de securitate</a></li>
              <li><a href="#calitate5"><span>5.4 </span>Atribute de calitate software</a></li>
            </ul>
          </li>
        </ul>

<!-- ----------------------------------------- -->
<div>
    <section typeof="sa:AuthorsList">
        <h2>Authors</h2>
        <ul>
          <li typeof="sa:ContributorRole" property="schema:author">
            <span typeof="schema:Person">
              <meta property="schema:givenName" content="Ion">
              <meta property="schema:familyName" content="Bordea">
              <span property="schema:name">Ion Bordea</span>
              <a href="#note1" property="sa:roleAction" resource="#note1" rel="footnote"></a>
            </span>
            <ul>
              <li property="schema:roleContactPoint" typeof="schema:ContactPoint">
                <a href="mailto:johnbordea@gmail.com"
                   property="schema:email">johnbordea@gmail.com</a>
              </li>
            </ul>
          </li>

          <li typeof="sa:ContributorRole" property="schema:author">
            <span typeof="schema:Person">
              <meta property="schema:givenName" content="Morariu">
              <meta property="schema:familyName" content="Georgiana">
              <span property="schema:name">Morariu Georgiana</span>
              <a href="#note1" property="sa:roleAction" resource="#note1" rel="footnote"></a>
            </span>
            <ul>
              <li property="schema:roleContactPoint" typeof="schema:ContactPoint">
                <a href="mailto:morariu.georgiana.26@gmail.com"
                   property="schema:email">morariu.georgiana.26@gmail.com</a>
              </li>
            </ul>
          </li>
        </ul>
      </section>
</div>
<section id="revizuiri">
  <h2>Istoricul revizuirilor</h2>
</section>
<section id="introduction" role="doc-introduction">
  <h2>Introducere</h2>
    <section id="scop1">
      <h3>1.1 Scop</h3>
      <p>Acest document a fost creat cu scopul de a oferi informatii ale proiectului "Actors Smart Visualiser", 
        realizat în anul univesitar 2023-2024, în cadrul disciplinei Tehnologii WEB de la Facultatea de Informatică Iași.
      </p>
    </section>
    <section id="conventii1">
      <h3>1.2 Conventii ale documentului</h3>
      <p>
        Pentru realizarea acestei documentații s-a utilizat formatul <a href="https://w3c.github.io/scholarly-html/#abstract">Scholarly HTML</a>, conform cerințelor proiectului.
      </p>
    </section>
    <section id="publicul1">
      <h3>1.3 Publicul vizat</h3>
      <p>Documentul este destinat profesorilor ce vor evalua acest proiect împreuna cu functionalitatile lui, 
        dar si oricarei persoane interesate de constructia aplicatiei sau de modul de funcționare.</p>
    </section>
    <section id="domeniul1">
      <h3>1.4 Domeniul de aplicare al produsului</h3>
      <p>Aplicatia WEB are scopul de a crea o interfata digitala, usor de folosit de catre toti utilizatorii, 
        iar cei interesați să se informeze despre cum va lucra aplicația în detaliu.
      </p>
    </section>
    <section id="referinte1">
      <h3>1.5 Referinte</h3>
      <p>Formatul <a href="https://w3c.github.io/scholarly-html/#abstract">Scholarly HTML</a>
      </p>
      <p>
        Template utilizat <a href="https://github.com/rick4470/IEEE-SRS-Tempate#41-system-feature-1"> IEEE System Requirements Specification Template</a>
      </p>
    </section>
</section>
<section id="ovarall-description" role="app-description">
  <h2>Descrierea generala a aplicatiei</h2>
    <section id="perspectiva2">
      <h3>2.1 Perspectiva produsului</h3>
      <p>
        AcVis (Actors Smart Visualiser) este un instrument Web de vizualizare flexibila a datelor referitoare la nominalizarile actorilor la Screen Actors Guid (SAG) Awards.
        Adițional se va oferi date privind actorii nominalizați.
      </p>
    </section>
    <section id="functii2">
      <h3>2.2 Functiile produsului </h3>
      <div>
        <p>Utilizatorul va avea urmatoarele functionalitati in cadrul aplicatiei:</p>
        <ul>
            <li> să îsi creeze cont;</li>
            <li> să se conecteze la un cont deja existent;</li>
            <li> să-și vizualizeze contul cu informații personale(nume, prenume, username-ul și o listă de actori pe care îi urmărește)</li>
            <li> să vizualizeze nominalizații și câștigătorii SAG Awards </li>
            <li> adminul va fi capabil să ștearga instanțele utilizatorilor(nu va fi capabil să le modifice) </li>
            <li> adminul va fi capabil să modifice instanțele actorilor </li>
            <li> adminul va fi capabil să modifice instanțele SAG Awards </li>
        </ul>
      </div>
    </section>
    <section id="caracteristici2">
      <h3>2.3 Clasele si caracteristicile utilizatorilor </h3>
      <p> Aplicatia este destinata oricarei persoane ce va fi interesată în vizualizarea informațiilor privind SAG Awards.
        </p>
    </section>
    <section id="mediu-operare2">
      <h3>2.4 Mediul de operare</h3>
      <p>Aplicatia va fi disponibila atat pe dispozitive de tip desktop cat si dispozitive mobile, in orice browser ce suporta HTML5. </p>
    </section>
    <section id="constrangeri2">
      <h3>2.5 Constrangeri de proiectare si implementare</h3>
      <p>Aplicatia este construita de la 0, fara utilizarea vreunui framework, utilizand doar cod HTML, CSS, JavaScript și pentru backend se va folosi PHP.</p>
    </section>
    <section id="documentatie2">
      <h3>2.6 Documentatia utilizatorului</h3>
      <p>Nu va fi nevoie de un manual de utilizare al aplicatiei și nici de tutoriale, aceasta fiind destul de interactivă și intuitivă. </p>
    </section>
    <section id="ipoteze2">
      <h3>2.7 Ipoteze si dependente</h3>
      <p>
        Singurul factor de care depinde aplicația pentru o bună utilizare este conexiunea la o sursă de internet.
      </p>
    </section>
</section>
<section id="external-interface-requirments" role="app-interface">
  <h2>Cerinte de interfata externa</h2>
  <section id="interfata-utilizator3" role="external-interface-requirments-sections">
    <h3>3.1 Interfata cu utilizatorul</h3>
    <p> Pagina de login ofera utilizatorului optiunea de a se conecta sau de a crea un cont nou. </p>
    <img src="assets/imgs/login.png">
    <p>Bara de activități a paginii principale conție: </p>
        <ul>
            <li> Link spre pagina principala</li>
            <li> Link spre pagina About</li>
            <li> Link spre pagina utilizatorului(dacă este logat) </li>
            <li> Un panou de navigare(pentru a căuta actorul dorit) </li>
        </ul>
  </section>
  <section id="interfata-hardwere3"> 
    <h3 >3.2 Interfete hardware</h3>
    <p> Urmarim ca programul sa functioneze pe orice sistem desktop sau mobile, unul din factorii ce fac acest lucru posibil fiind 
      doar dependența conexiunii la internet . 
    </p> 
    <p>
       În scopul utilizării mobile am realizat o interfață responsive, cu un meniu special conceput pentru dispozitivele mobile.  
    </p>
  </section>
  <section id="interfata-softwere3">
    <h3>3.3 Interfete software</h3>
    Urmarim ca programul sa functioneze pe orice sistem de operare cum ar f: Linux, MacOS, iOS, Android.
    Aplicația folosește o conexiune la o bază de date MySQL pentru păstrarea tuturor informațiilor necesare cum ar fi cele legate 
    de alimentele stocate pe site, dar și informatiile despre acestea. Toate paginile sunt realizate cu ajutorul: HTML, CSS, JavaScript și PHP. 
  </section>
  <section id="interfata-comunicare3">
    <h3>3.4 Interfete de comunicare</h3>
    <p> 
      Aplicația functionează pe un browser WEB, deci bineînțeles că are nevoie de o conexiune la internet pentru funcționare.
      Pentru a putea avea acces la funcționalitățile aplicațieie trbuie ca mai întâi să ne înregistrăm. 
      Pentru înregistrare va trebui să furnizăm următoarele date personale: nume și prenume, adresă de email și o parolă. 
      Aceste informații vor fi stocate criptat, într-o bază de date MySQL. 
      Adresa de email și parola sunt necesare pentru accesul în cont la login.
    </p>
  </section>
</section>

<section id="system-features" role="app-features">
    <h2>4. Caracteristicile sistemului</h2>
    <p> Gestionarea Contului utilizatorului</p>
    <ul>
        <li> Modificarea datelor personale </li>
        <li> Abonarea/dezabonarea Actorilor</li>
    </ul>
    <p> Gestionarea datelor bazei de date </p>
    <ul>
        <li> Modificarea datelor privind informația actorilor </li>
        <li> Modificarea datelor privind informația SAG Awards </li>
        <li> Exportarea datelor în format CSV </li>
        <li> Importarea datelor din format CSV(tabelul nu va fi șters, ci datele for fi update-ate dacă acea instanță există) </li>
    </ul>

    <p> Vizualizarea datelor generale </p>
    <ul>
        <li> Vizualizarea datelor privind nominalizările SAG Awards </li>
        <li> Vizualizarea datelor privind datele actorilor </li>
    </ul>
</section>

<section id="other-nonfunctional-requirments" role="app-requirments">
  <h2>Alte cerinte</h2>
  <section id="performanta5" role="other-nonfunctional-requirments-sections">
    <h3>5.1 Cerinte de performanta</h3>
    <p> Pentru o buna functionare a aplicatie este nevoie de o conexiune stabila la internet, aceasta fiind principala sursa de functionare. 
       O cerință ar fi evitarea supraîncărcării paginilor de cod cu doarte multe functionalități, de asemenea se recomandă
       o foarte mare atenție asura câmpurilor din baza de date,toate acestea fiind obligatorii pentru a facilita funcționalitatea
       aplicației și din acest motiv validările câmpurilor sunt obligatorii.
    </p>
  </section>
  <section id="siguranta5">
    <h3>5.2 Cerinte de siguranta in cadrul aplicatiei </h3>
    <p> 
      Toti utilizatorii trebuie să furnizeze o parolă puternică pentru a evita spargerea contului. Se recomandă
      ca parola sa nu fie utilizată și în cadrul altor aplicații.     
    </p>
    <p>
      Baza de date reprezinta cea mai importantă componentă a aplicațieie, dar și cea mai predispusă la deteriorare 
      și din accest motiv criptatrea tuturor datelor este obligatorie pentru o bună securitate a datelor oferite de utilizator.
    </p>
  </section>
  <section id="securitate5">
    <h3>5.3 Cerinte de securitate </h3>
    <p>
      Utilizatorii au acces in cont pe baza adresei de email și a parolei furnizate. Uitarea sau pierderea acestor date 
      duce la pierderea accesului în cont, fără a mai putea fi recuperat. 
    </p>
    <p>
      Furnizarea datelor de conectare altor persoane poate duce la deteriorarea datelor contului.
    </p>
  </section>
  <section id="calitate5">
    <h3>5.4 Atribute de calitate software </h3>
    <p>
      Aplicația este disponibilă atat pe versiunea mobilă cât și pe versiunea dekstop, iar acest lucru înseamnă că interfața necesită
      adaptată constant la ambele categorii de cerințe.    
    </p>
    <p>
      Pentru o bună funcționare pe toate sistemele de operare, aplicația nu trebuie să conțină limitări și din acest motiv
      nu se recomandă utilizarea framework-urilor.
    </p>
  </section>
</section>

</body>

</html>