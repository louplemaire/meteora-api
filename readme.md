# 🔭 METEORA API
> 🔭 METEORA API gives you meteors informations
>
> ☄️ This API is created for <a href="https://meteora.netlify.app" alt="METEORA">METEORA</a> project (<a href="https://github.com/RomainPct/meteora" alt="METEORA's repository">the repository</a>)

## 💻 Stack
- <a href="https://www.php.net/" alt="PHP">PHP</a> as programming language
- <a href="https://www.mamp.info/en/mac/" alt="MAMP">MAMP</a> to launch the server
- <a href="https://www.phpmyadmin.net/" alt="phpMyAdmin">phpMyAdmin</a> for the MySQL database
- <a href="https://insomnia.rest/" alt="Insomnia">Insomnia</a> to test the API

## 🔧 Start
Connect to the API with this url : ```https://meteora-api.louplemaire.fr```

## 📣 API endpoints
| Endpoint | Description |
| --- | --- |
| getMeteors | List of meteors of the year |
| getDetailedMeteor | Get all the meteor informations |
| getMeteorWeights | List of meteor masses of the year |
| getMedianWeight | Get the median meteor weight for the year |
| getAverageMass | Get the average mass of meteors of the year |
| getBiggestMeteor | Get the biggest meteor of the year |
| getSmallestMeteor | Get the smallest meteor of the year |
| getAvailableYears | List of year with the count of meteors |
| countFallenMeteors | Get the number of fallen meteors of the year |

## 🛠 This API uses
- 🚀 <a href="https://data.nasa.gov/Space-Science/Meteorite-Landings/gh4g-9sfh" alt="NASA's Open Data">NASA's Open Data</a> to recover information on all of the known meteor landings

- 🗺 <a href="https://opencagedata.com" alt="OpenCage">OpenCage</a> API to convert latitude and longitude coordinates of NASA's data to get the place where the meteor fell

> ⚠️ WARNING : This site has been created for educational purposes as part of the Grande Ecole curriculum of the HETIC school. The contents and data presented have not been the subject of a request for right of use. This site will in no case be exploited for commercial purposes.