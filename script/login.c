#include <sys/types.h>
#include <sys/stat.h>
#include <sys/fcntl.h>
#include <time.h>
#include <stdio.h>
#include <ctype.h>
#include <utmp.h>
#include <errno.h>
#include <malloc.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <signal.h>
#include <getopt.h>
#include <netinet/in.h>
#include <netdb.h>
#include <arpa/inet.h>
#include "oldutmp.h"

#ifndef SHUTDOWN_TIME
#  define SHUTDOWN_TIME 254
#endif

#define NEW_UTMP	1	/* Fancy & fast utmp read code. */
#define UCHUNKSIZE	16384	/* How much we read at once. */

/* Double linked list of struct utmp's */
struct utmplist {
  struct utmp ut;
  struct utmplist *next;
  struct utmplist *prev;
};
struct utmplist *utmplist = NULL;

/* Types of listing */
#define R_CRASH		1 /* No logout record, system boot in between */
#define R_DOWN		2 /* System brought down in decent way */
#define R_NORMAL	3 /* Normal */
#define R_NOW		4 /* Still logged in */
#define R_REBOOT	5 /* Reboot record. */
#define R_PHANTOM	6 /* No logout record but session is stale. */
#define R_TIMECHANGE	7 /* NEW_TIME or OLD_TIME */

/* Global variables */
FILE *fp1;
int icount = 0;
char **show = NULL;	/* What do they want us to show */
char *ufile;		/* Filename of this file */
time_t lastdate;	/* Last date we've seen */
char *progname;		/* Name of this program */
/*
 *	Read one utmp entry, return in new format.
 *	Automatically reposition file pointer.
 */
int uread(FILE *fp, struct utmp *u, int *quit)
{
	static int utsize;
	static char buf[UCHUNKSIZE];
	char tmp[1024];
	static off_t fpos;
	static int bpos;
	struct oldutmp uto;
	int r;
	off_t o;

	if (quit == NULL && u != NULL) {
		/*
		 *	Normal read.
		 */
		r = fread(u, sizeof(struct utmp), 1, fp);
		return r;
	}

	if (u == NULL) {
		/*
		 *	Initialize and position.
		 */
		utsize =  sizeof(struct utmp);
		fseeko(fp, 0, SEEK_END);
		fpos = ftello(fp);
		if (fpos == 0)
			return 0;
		o = ((fpos - 1) / UCHUNKSIZE) * UCHUNKSIZE;
		if (fseeko(fp, o, SEEK_SET) < 0) {
			fprintf(stderr, "%s: seek failed!\n", progname);
			return 0;
		}
		bpos = (int)(fpos - o);
		if (fread(buf, bpos, 1, fp) != 1) {
			fprintf(stderr, "%s: read failed!\n", progname);
			return 0;
		}
		fpos = o;
		return 1;
	}

	/*
	 *	Read one struct. From the buffer if possible.
	 */
	bpos -= utsize;
	if (bpos >= 0) {
		memcpy(u, buf + bpos, sizeof(struct utmp));
		return 1;
	}

	/*
	 *	Oops we went "below" the buffer. We should be able to
	 *	seek back UCHUNKSIZE bytes.
	 */
	fpos -= UCHUNKSIZE;
	if (fpos < 0)
		return 0;

	/*
	 *	Copy whatever is left in the buffer.
	 */
	memcpy(tmp + (-bpos), buf, utsize + bpos);
	if (fseeko(fp, fpos, SEEK_SET) < 0) {
		perror("fseek");
		return 0;
	}

	/*
	 *	Read another UCHUNKSIZE bytes.
	 */
	if (fread(buf, UCHUNKSIZE, 1, fp) != 1) {
		perror("fread");
		return 0;
	}

	/*
	 *	The end of the UCHUNKSIZE byte buffer should be the first
	 *	few bytes of the current struct utmp.
	 */
	memcpy(tmp, buf + UCHUNKSIZE + bpos, -bpos);
	bpos += UCHUNKSIZE;

	memcpy(u, tmp, sizeof(struct utmp));

	return 1;
}

/*
 *	Try to be smart about the location of the BTMP file
 */
#ifndef BTMP_FILE
#define BTMP_FILE getbtmp()
char *getbtmp()
{
	static char btmp[128];
	char *p;

	strcpy(btmp, WTMP_FILE);
	if ((p = strrchr(btmp, '/')) == NULL)
		p = btmp;
	else
		p++;
	*p = 0;
	strcat(btmp, "btmp");
	return btmp;
}
#endif
//TODO next three function could delete?
/*
 *	Print a short date.
 */
char *showdate()
{
	char *s = ctime(&lastdate);
	s[16] = 0;
	return s;
}

/*
 *	SIGINT handler
 */
void int_handler()
{
	printf("Interrupted %s\n", showdate());
	exit(1);
}

/*
 *	SIGQUIT handler
 */
void quit_handler()
{
	printf("Interrupted %s\n", showdate());
	signal(SIGQUIT, quit_handler);
}

/*
 *	Get the basename of a filename
 */
char *mybasename(char *s)
{
	char *p;

	if ((p = strrchr(s, '/')) != NULL)
		p++;
	else
		p = s;
	return p;
}

void getSTime(time_t time,char* out){
  struct tm *utime;
  utime = gmtime(&time);
  snprintf(out,64,"%d-%d-%d %d:%d:%d",1900+utime->tm_year,1+utime->tm_mon,utime->tm_mday,utime->tm_hour,utime->tm_min,utime->tm_sec);
  }

void write_file(FILE *fp,char *c){
    char *s =NULL;
    for (s = c; *s; s++) {
		if (*s == '\n' || (*s >= 32 && (unsigned char)*s <= 126)){
      fwrite(s,sizeof(char),1,fp);
    }
		else{
      char f = '*';
      fwrite(&f,sizeof(char),1,fp);
			//putchar('*');
    }
	}
}

/*
 *	Show one line of information on screen
 */
int list(struct utmp *p, time_t t, int what)
{
	time_t		secs, tmp;
	char		logintime[32];
	char		logouttime[32];
	char		length[32];
	char		final[512];
	char		utline[UT_LINESIZE+1];
	char		domain[256];
	char		*s, **walk;
	int		mins, hours, days;
	int		r, len;
  char out[64];
	/*
	 *	uucp and ftp have special-type entries
	 */
	utline[0] = 0;
	strncat(utline, p->ut_line, UT_LINESIZE);
	if (strncmp(utline, "ftp", 3) == 0 && isdigit(utline[3]))
		utline[3] = 0;
	if (strncmp(utline, "uucp", 4) == 0 && isdigit(utline[4]))
		utline[4] = 0;

	/*
	 *	Is this something we wanna show?
	 */
	if (show) {
		for (walk = show; *walk; walk++) {
			if (strncmp(p->ut_name, *walk, UT_NAMESIZE) == 0 ||
			    strcmp(utline, *walk) == 0 ||
			    (strncmp(utline, "tty", 3) == 0 &&
			     strcmp(utline + 3, *walk) == 0)) break;
		}
		if (*walk == NULL) return 0;
	}

	/*
	 *	Look up domain.
	 */
    len = UT_HOSTSIZE;
    if (len >= (int)sizeof(domain)) len = sizeof(domain) - 1;
    domain[0] = 0;
    strncat(domain, p->ut_host, len);

	/*
	 *	Calculate times
   * TODO
	 */
	tmp = (time_t)p->ut_time;
    getSTime(tmp,logintime);
    getSTime(t,logouttime);
	secs = t - p->ut_time;
	mins  = (secs / 60) % 60;
	hours = secs / 3600;
	sprintf(length, " %02d:%02d", hours, mins);

	switch(what) {
		case R_CRASH:
			sprintf(logouttime, "crash");
			break;
		case R_DOWN:
			sprintf(logouttime, "down ");
			break;
		case R_NOW:
			length[0] = 0;
				sprintf(logouttime, "still logged in");
			break;
		case R_PHANTOM:
			length[0] = 0;
				sprintf(logouttime, "gone");
			break;
		case R_REBOOT:
			break;
		case R_TIMECHANGE:
			logouttime[0] = 0;
			length[0] = 0;
			break;
		case R_NORMAL:
			break;
 	}
    if(!strcmp(ufile,BTMP_FILE)){
	    sprintf(logouttime, "fail");
    }
	len = snprintf(final, sizeof(final),
            		"<item><name>%-8.8s</name> <ter>%-12.12s</ter> <ip>%-16.16s</ip> <datetime>%-24.24s</datetime> <status>%-26.26s</status> <last>%-12.12s</last></item>\n", 
			        	 p->ut_name, utline, domain, logintime, logouttime, length);

#if defined(__GLIBC__)
#  if (__GLIBC__ == 2) && (__GLIBC_MINOR__ == 0)
	final[sizeof(final)-1] = '\0';
#  endif
#endif
    write_file(fp1,final);
    icount++;

	return 0;
}
time_t parsetm(char *ts)
{
	struct tm	u, origu;
	time_t		tm;

	memset(&tm, 0, sizeof(tm));

	if (sscanf(ts, "%4d%2d%2d%2d%2d%2d", &u.tm_year,
	    &u.tm_mon, &u.tm_mday, &u.tm_hour, &u.tm_min,
	    &u.tm_sec) != 6)
		return (time_t)-1;

	u.tm_year -= 1900;
	u.tm_mon -= 1;
	u.tm_isdst = -1;

	origu = u;

	if ((tm = mktime(&u)) == (time_t)-1)
		return tm;

	/*
	 *	Unfortunately mktime() is much more forgiving than
	 *	it should be.  For example, it'll gladly accept
	 *	"30" as a valid month number.  This behavior is by
	 *	design, but we don't like it, so we want to detect
	 *	it and complain.
	 */
	if (u.tm_year != origu.tm_year ||
	    u.tm_mon != origu.tm_mon ||
	    u.tm_mday != origu.tm_mday ||
	    u.tm_hour != origu.tm_hour ||
	    u.tm_min != origu.tm_min ||
	    u.tm_sec != origu.tm_sec)
		return (time_t)-1;

	return tm;
}

int main(int argc, char **argv)
{
  FILE *fp;		/* Filepointer of wtmp file */
  struct utmp ut;	/* Current utmp entry */
  struct utmp oldut;	/* Old utmp entry to check for duplicates */
  struct utmplist *p;	/* Pointer into utmplist */
  struct utmplist *next;/* Pointer into utmplist */

  time_t lastboot = 0;  /* Last boottime */
  time_t lastrch = 0;	/* Last run level change */
  time_t lastdown;	/* Last downtime */
  time_t begintime;	/* When wtmp begins */
  int whydown = 0;	/* Why we went down: crash or shutdown */

  int c, x;		/* Scratch */
  struct stat st;	/* To stat the [uw]tmp file */
  int quit = 0;		/* Flag */
  int down = 0;		/* Down flag */
  int lastb = 0;	/* Is this 'lastb' ? */
  int extended = 0;	/* Lots of info. */
  char *altufile = NULL;/* Alternate wtmp */
  char *flag = NULL;
  time_t until = 0;	/* at what time to stop parsing the file */
  char *s = NULL;
  char f;
  fp1 = fopen("./login.xml","w+"); 
  flag = "<xml>\n";
  write_file(fp1,flag);
  progname = mybasename(argv[0]);


  time(&lastdown);
  lastrch = lastdown;

  /*
   *	Fill in 'lastdate'
   */
  lastdate = lastdown;

  /*
   *	Install signal handlers
   */
  signal(SIGINT, int_handler);
  signal(SIGQUIT, quit_handler);

  for(;;){
    if(ufile==NULL){
        ufile = BTMP_FILE;
        lastb = 1;
    }else if(!strcmp(BTMP_FILE,ufile)){
        ufile = WTMP_FILE;
        lastb = 0;
    }else{
        break;    
    }
  /*
   *	Open the utmp file
   */
  if ((fp = fopen(ufile, "r")) == NULL) {
	x = errno;
	fprintf(stderr, "%s: %s: %s\n", progname, ufile, strerror(errno));
	if (altufile == NULL && x == ENOENT)
		fprintf(stderr, "Perhaps this file was removed by the "
			"operator to prevent logging %s info.\n", progname);
	exit(1);
  }

  /*
   *	Optimize the buffer size.
   */
  setvbuf(fp, NULL, _IOFBF, UCHUNKSIZE);

  /*
   *	Read first structure to capture the time field
   */
  if (uread(fp, &ut, NULL) == 1)
	  begintime = ut.ut_time;
  else {
  	fstat(fileno(fp), &st);
	  begintime = st.st_ctime;
	  quit = 1;
  }
  /*
   *	Go to end of file minus one structure
   *	and/or initialize utmp reading code.
   */
  uread(fp, NULL, NULL);
  /*
   *	Read struct after struct backwards from the file.
   */
  while(!quit) {

	if (uread(fp, &ut, &quit) != 1)
		break;

	if (until && until < ut.ut_time)
		continue;

	if (memcmp(&ut, &oldut, sizeof(struct utmp)) == 0) continue;
	  memcpy(&oldut, &ut, sizeof(struct utmp));
	lastdate = ut.ut_time;

  	if (lastb) {
  		quit = list(&ut, ut.ut_time, R_NORMAL);
  		continue;
        printf("lastb is run");
  	}

	/*
	 *	Set ut_type to the correct type.
	 */
	if (strncmp(ut.ut_line, "~", 1) == 0) {
		if (strncmp(ut.ut_user, "shutdown", 8) == 0)
			ut.ut_type = SHUTDOWN_TIME;
		else if (strncmp(ut.ut_user, "reboot", 6) == 0)
			ut.ut_type = BOOT_TIME;
		else if (strncmp(ut.ut_user, "runlevel", 8) == 0)
			ut.ut_type = RUN_LVL;
	}
#if 1 /*def COMPAT*/
	/*
	 *	For stupid old applications that don't fill in
	 *	ut_type correctly.
	 */
	else {
		if (ut.ut_type != DEAD_PROCESS &&
		    ut.ut_name[0] && ut.ut_line[0] &&
		    strcmp(ut.ut_name, "LOGIN") != 0)
			ut.ut_type = USER_PROCESS;
		/*
		 *	Even worse, applications that write ghost
		 *	entries: ut_type set to USER_PROCESS but
		 *	empty ut_name...
		 */
		if (ut.ut_name[0] == 0)
			ut.ut_type = DEAD_PROCESS;

		/*
		 *	Clock changes.
		 */
		if (strcmp(ut.ut_name, "date") == 0) {
			if (ut.ut_line[0] == '|') ut.ut_type = OLD_TIME;
			if (ut.ut_line[0] == '{') ut.ut_type = NEW_TIME;
		}
	}
#endif

	switch (ut.ut_type) {
		case SHUTDOWN_TIME:
			if (extended) {
				strcpy(ut.ut_line, "system down");
				quit = list(&ut, lastboot, R_NORMAL);
			}
			lastdown = lastrch = ut.ut_time;
			down = 1;
			break;
		case OLD_TIME:
		case NEW_TIME:
			if (extended) {
				strcpy(ut.ut_line,
				ut.ut_type == NEW_TIME ? "new time" :
					"old time");
				quit = list(&ut, lastdown, R_TIMECHANGE);
			}
			break;
		case BOOT_TIME:
			strcpy(ut.ut_line, "system boot");
			quit = list(&ut, lastdown, R_REBOOT);
			lastboot = ut.ut_time;
			down = 1;
			break;
		case RUN_LVL:
			x = ut.ut_pid & 255;
			if (extended) {
				sprintf(ut.ut_line, "(to lvl %c)", x);
				quit = list(&ut, lastrch, R_NORMAL);
			}
			if (x == '0' || x == '6') {
				lastdown = ut.ut_time;
				down = 1;
				ut.ut_type = SHUTDOWN_TIME;
			}
			lastrch = ut.ut_time;
			break;

		case USER_PROCESS:
				/*
			 *	This was a login - show the first matching
			 *	logout record and delete all records with
			 *	the same ut_line.
			 */
			c = 0;
			for (p = utmplist; p; p = next) {
				next = p->next;
				if (strncmp(p->ut.ut_line, ut.ut_line,
				    UT_LINESIZE) == 0) {
					/* Show it */
					if (c == 0) {
						quit = list(&ut, p->ut.ut_time,
							R_NORMAL);
						c = 1;
					}
					if (p->next) p->next->prev = p->prev;
					if (p->prev)
						p->prev->next = p->next;
					else
						utmplist = p->next;
					free(p);
				}
			}
			/*
			 *	Not found? Then crashed, down, still
			 *	logged in, or missing logout record.
			 */
			if (c == 0) {
				if (lastboot == 0) {
					c = R_NOW;
					/* Is process still alive? */
					if (ut.ut_pid > 0 &&
					    kill(ut.ut_pid, 0) != 0 &&
					    errno == ESRCH)
						c = R_PHANTOM;
				} else
					c = whydown;
				quit = list(&ut, lastboot, c);
			}
			/* FALLTHRU */

		case DEAD_PROCESS:
			/*
			 *	Just store the data if it is
			 *	interesting enough.
			 */
			if (ut.ut_line[0] == 0)
				break;
			if ((p = malloc(sizeof(struct utmplist))) == NULL) {
				fprintf(stderr, "%s: out of memory\n",
					progname);
				exit(1);
			}
			memcpy(&p->ut, &ut, sizeof(struct utmp));
			p->next  = utmplist;
			p->prev  = NULL;
			if (utmplist) utmplist->prev = p;
			utmplist = p;
			break;

	}
	/*
	 *	If we saw a shutdown/reboot record we can remove
	 *	the entire current utmplist.
	 */
	if (down) {
		lastboot = ut.ut_time;
		whydown = (ut.ut_type == SHUTDOWN_TIME) ? R_DOWN : R_CRASH;
		for (p = utmplist; p; p = next) {
			next = p->next;
			free(p);
		}
		utmplist = NULL;
		down = 0;
	}
  }
  char BT[32];
  getSTime(begintime,BT);
  }
  printf("%d",icount);
  flag = "</xml>\n";
  write_file(fp1,flag);
  fclose(fp);
  fclose(fp1);

  /*
   *	Should we free memory here? Nah. This is not NT :)
   */
  return 0;
}
