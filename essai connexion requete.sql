select u.userId as "user_id", u.userPseudo as "username", u.userEmail as "email", 
u.userCreationDate as "create_time", u.userQuestion as "question_secrete", u.userAnswer as "reponse_secrete", group_concat(distinct up.profilId separator ',') as profil_Id
from user as u inner join user_profil as up on u.userId = up.userId
where u.userMdp = md5(concat(u.userSemence, "anonyme"))
group by u.userId, u.userPseudo